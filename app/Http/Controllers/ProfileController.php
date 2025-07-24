<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function editProfile()
    {
        return view('profile.editProfile');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ], [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
        ]);

        $user->update($validated);

        return redirect()->route('edit.profile')->with('success_profile', 'Profile berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'passwordSaatIni' => 'required',
            'password' => 'required|min:6',
            'confirmPassword' => 'required|same:password'
        ], [
            'passwordSaatIni.required' => 'Password lama wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 6 karakter.',
            'confirmPassword.same' => 'Konfirmasi password tidak sesuai.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->passwordSaatIni, $user->password)) {
            return back()->withErrors(['passwordSaatIni' => 'Password saat ini tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('edit.profile')->with('success_password', 'Password berhasil diperbarui.');
    }
}
