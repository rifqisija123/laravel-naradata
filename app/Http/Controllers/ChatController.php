<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ChatController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('chats.chats', compact('users'));
    }

    public function getUsers()
    {
        $users = User::where('id', '!=', Auth::id())
            ->select('id', 'name', 'email', 'last_seen')
            ->get()
            ->map(function ($user) {
                $unreadCount = Chat::where('sender_id', $user->id)
                    ->where('receiver_id', Auth::id())
                    ->where('status', '!=', 'read')
                    ->count();
                    
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'is_online' => $user->isOnline(),
                    'last_seen' => $user->last_seen ? $user->last_seen->diffForHumans() : 'Tidak pernah online',
                    'unread_count' => $unreadCount
                ];
            });

        return response()->json($users);
    }

    public function getMessages(Request $request)
    {
        $receiverId = $request->receiver_id;
        $userId = Auth::id();

        $messages = Chat::where(function ($query) use ($userId, $receiverId) {
            $query->where('sender_id', $userId)
                  ->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($userId, $receiverId) {
            $query->where('sender_id', $receiverId)
                  ->where('receiver_id', $userId);
        })
        ->with(['sender', 'receiver'])
        ->orderBy('created_at', 'asc')
        ->get();

        // Mark messages as read
        Chat::where('sender_id', $receiverId)
            ->where('receiver_id', $userId)
            ->where('status', '!=', 'read')
            ->update([
                'status' => 'read',
                'read_at' => now()
            ]);

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000'
        ]);

        $receiver = User::find($request->receiver_id);
        $status = $receiver->isOnline() ? 'delivered' : 'sent';

        $chat = Chat::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'status' => $status
        ]);

        $chat->load(['sender', 'receiver']);

        return response()->json([
            'success' => true,
            'message' => $chat
        ]);
    }

    public function updateLastSeen()
    {
        Auth::user()->update(['last_seen' => now()]);
        
        // Update status pesan yang belum dibaca menjadi delivered jika user online
        Chat::where('receiver_id', Auth::id())
            ->where('status', 'sent')
            ->update(['status' => 'delivered']);
            
        return response()->json(['success' => true]);
    }

    public function markAsRead(Request $request)
    {
        $receiverId = $request->receiver_id;
        $userId = Auth::id();

        Chat::where('sender_id', $receiverId)
            ->where('receiver_id', $userId)
            ->where('status', '!=', 'read')
            ->update([
                'status' => 'read',
                'read_at' => now()
            ]);

        return response()->json(['success' => true]);
    }

    public function getUnreadCount()
    {
        $unreadCount = Auth::user()->getUnreadMessagesCount();
        return response()->json(['unread_count' => $unreadCount]);
    }
}
