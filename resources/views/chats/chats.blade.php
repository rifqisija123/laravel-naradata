@extends('layouts.chat')

@section('title', 'Chat')

@section('content-chat')
<!-- Main Chat Container -->
<div class="container-fluid mt-4 px-4">
    <div class="row h-100">
        
        <!-- Sidebar - User List -->
        <div class="col-md-4 col-lg-3">
            <div class="card chat-sidebar h-100">
                <!-- Sidebar Header -->
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <a href="{{ route('dashboard') }}">
                        <i class="fa fa-arrow-left me-4 text-white"></i>
                    </a>
                    <i class="fas fa-comments me-2"></i>
                    <h5 class="mb-0">Chat</h5>
                </div>
                
                <!-- Sidebar Body -->
                <div class="card-body p-0 d-flex flex-column">
                    <!-- Search Box -->
                    <div class="p-3 border-bottom">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white border-0 ps-2">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" 
                                   class="form-control border-0" 
                                   id="userSearch" 
                                   placeholder="Cari pengguna...">
                        </div>
                    </div>
                    
                    <!-- Users List -->
                    <div class="flex-grow-1 overflow-auto" id="usersList">
                        <!-- Users will be loaded via AJAX -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Chat Area -->
        <div class="col-md-8 col-lg-9">
            <div class="card chat-main h-100">
                
                <!-- Chat Header -->
                <div class="card-header bg-light d-flex align-items-center justify-content-between" 
                     id="chatHeader" 
                     style="display: none;">
                    <div class="d-flex align-items-center">
                        <div class="avatar me-3 position-relative">
                            <i class="fas fa-user-circle fa-2x text-primary"></i>
                            <span class="position-absolute bottom-0 end-0 badge rounded-pill bg-success" 
                                  id="headerUserStatus" 
                                  style="width: 12px; height: 12px; font-size: 0;"></span>
                        </div>
                        <div>
                            <h6 class="mb-0" id="selectedUserName">Pilih pengguna untuk memulai chat</h6>
                            <small class="text-muted" id="selectedUserEmail"></small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-secondary" id="userStatus">Offline</span>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary" 
                                    type="button" 
                                    data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#" id="viewProfile">
                                        <i class="fas fa-user me-2"></i>Lihat Profil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" id="blockUser">
                                        <i class="fas fa-ban me-2"></i>Blokir
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Messages Area -->
                <div class="card-body chat-messages p-0" id="chatMessages">
                    <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                        <div class="text-center">
                            <i class="fas fa-comments fa-4x mb-3 opacity-50"></i>
                            <h5>Selamat datang di Chat</h5>
                            <p class="mb-0">Pilih pengguna dari sidebar untuk memulai percakapan</p>
                        </div>
                    </div>
                </div>

                <!-- Message Input -->
                <div class="card-footer bg-white border-top" 
                     id="chatInput" 
                     style="display: none;">
                    <form id="messageForm">
                        <div class="input-group">
                            <button class="btn btn-outline-secondary" 
                                    type="button" 
                                    id="attachBtn" 
                                    title="Lampirkan file">
                                <i class="fas fa-paperclip"></i>
                            </button>
                            <input type="text" 
                                   class="form-control" 
                                   id="messageInput" 
                                   placeholder="Ketik pesan..." 
                                   maxlength="1000">
                            <button class="btn btn-outline-secondary" 
                                    type="button" 
                                    id="emojiBtn" 
                                    title="Emoji">
                                <i class="fas fa-smile"></i>
                            </button>
                            <button class="btn btn-primary" 
                                    type="submit" 
                                    id="sendBtn" 
                                    title="Kirim pesan">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                    <div id="emojiPicker" style="display:none; position:absolute; bottom:70px; right:80px; z-index:1000;">
                        <emoji-picker></emoji-picker>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.container-fluid {
    height: calc(100vh - 80px);
}

.row.h-100 {
    height: 100%;
}

.chat-sidebar {
    height: 100%;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.chat-sidebar .card-header {
    border-radius: 10px 10px 0 0;
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    border: none;
}

.chat-sidebar .card-body {
    border-radius: 0 0 10px 10px;
}

.chat-main {
    height: 100%;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border: none;
}

.chat-main .card-header {
    border-radius: 10px 10px 0 0;
    border-bottom: 1px solid #e9ecef;
}

.chat-main .card-footer {
    border-radius: 0 0 10px 10px;
    border-top: 1px solid #e9ecef;
}

.chat-messages {
    height: calc(100% - 120px);
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    overflow-y: auto;
    padding: 20px;
}

.message {
    margin-bottom: 15px;
    display: flex;
    align-items: flex-end;
}

.message.new {
    animation: fadeInUp 0.3s ease-out;
}

.message.sent {
    justify-content: flex-end;
}

.message.received {
    justify-content: flex-start;
}

.message-content {
    max-width: 70%;
    padding: 12px 16px;
    border-radius: 18px;
    position: relative;
    word-wrap: break-word;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.message.sent .message-content {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
    border-bottom-right-radius: 5px;
}

.message.received .message-content {
    background: white;
    color: #333;
    border: 1px solid #e9ecef;
    border-bottom-left-radius: 5px;
}

.message-time {
    font-size: 0.7rem;
    color: rgba(255,255,255,0.8);
    margin-top: 5px;
    text-align: right;
}

.message.received .message-time {
    color: #6c757d;
    text-align: left;
}

#emojiPicker {
  background: white;
  border: 1px solid #ddd;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  max-height: 350px;
  overflow: hidden;
}

.message-status {
    font-size: 0.7rem;
    margin-top: 2px;
    text-align: right;
}

.status-sent {
    color: rgba(255,255,255,0.7);
}

.status-delivered {
    color: #28a745;
}

.status-read {
    color: #007bff;
}

.user-item {
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
    border-bottom: 1px solid #f1f3f4;
    padding: 12px 16px;
}

.user-item:hover {
    background-color: #f8f9fa;
    transform: translateX(2px);
}

.user-item.active {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    border-left: 4px solid #2196f3;
    transform: translateX(0);
}

.user-item:last-child {
    border-bottom: none;
}

.avatar {
    position: relative;
    display: inline-block;
}

.online-indicator,
.offline-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    position: absolute;
    bottom: 2px;
    right: 2px;
    border: 2px solid white;
    box-shadow: 0 0 0 1px #e9ecef;
}

.online-indicator {
    background-color: #28a745;
}

.offline-indicator {
    background-color: #6c757d;
}

.unread-count {
    position: absolute;
    top: -8px;
    right: -8px;
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
    color: white;
    border-radius: 50%;
    min-width: 20px;
    height: 20px;
    font-size: 0.7rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.input-group .form-control {
    border-radius: 25px;
    border: 1px solid #e9ecef;
    padding: 10px 15px;
}

.input-group .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
}

.input-group .btn {
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.input-group.input-group-sm {
    border: 1px solid #e9ecef;
    border-radius: 20px;
    overflow: hidden;
}

.input-group.input-group-sm .form-control,
.input-group.input-group-sm .input-group-text {
    border: none;
    box-shadow: none;
}

.input-group.input-group-sm .form-control:focus {
    box-shadow: none;
}

#userSearch {
    border-radius: 20px;
    border: 1px solid #e9ecef;
    font-size: 0.9rem;
}

#userSearch:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
}

.chat-messages::-webkit-scrollbar,
#usersList::-webkit-scrollbar {
    width: 6px;
}

.chat-messages::-webkit-scrollbar-track,
#usersList::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.chat-messages::-webkit-scrollbar-thumb,
#usersList::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.chat-messages::-webkit-scrollbar-thumb:hover,
#usersList::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.loading {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid #f3f3f3;
    border-top: 3px solid #007bff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@media (max-width: 768px) {
    .col-md-4, .col-md-8 {
        margin-bottom: 15px;
    }
    
    .chat-sidebar, .chat-main {
        height: 400px;
    }
    
    .message-content {
        max-width: 85%;
    }
}

@media (max-width: 576px) {
    .container-fluid {
        padding: 10px;
    }
    
    .message-content {
        max-width: 90%;
        padding: 10px 12px;
    }
    
    .user-item {
        padding: 10px 12px;
    }
    
    .input-group .btn {
        width: 35px;
        height: 35px;
    }
}
</style>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let selectedUserId = null;
    let messageInterval = null;
    let lastSeenInterval = null;
    let currentSearchTerm = '';
    let allUsers = [];

    function formatMessage(message) {
        return message.replace(/\n/g, '<br>');
    }

    function scrollToBottom() {
        const chatMessages = document.getElementById('chatMessages');
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function updateLastSeen() {
        $.post('/api/chat/update-last-seen', {
            _token: $('meta[name="csrf-token"]').attr('content')
        });
    }

    function loadUsers() {
        $.get('/api/chat/users')
            .done(function(users) {
                allUsers = users || [];
                renderUsersList(allUsers);
            })
            .fail(function() {
                showUsersError();
            });
    }

    function renderUsersList(users) {
        let list = users || [];

        if (currentSearchTerm && currentSearchTerm.trim() !== '') {
            const q = currentSearchTerm.trim().toLowerCase();
            list = list.filter(function(user) {
                const hay = ((user.name || '') + ' ' + (user.email || '') + ' ' + (user.last_seen || '')).toLowerCase();
                return hay.indexOf(q) !== -1;
            });
        }

        let html = '';
        if (list.length === 0) {
            html = getEmptyUsersHTML();
        } else {
            list.forEach(function(user) {
                html += getUserItemHTML(user);
            });
        }

        $('#usersList').html(html);

        if (selectedUserId) {
            const selectedEl = $(`.user-item[data-user-id="${selectedUserId}"]`);
            if (selectedEl.length) selectedEl.addClass('active');
            else {
                // kalau user yang dipilih hilang karena filter, sembunyikan chat header+input
                $('#chatHeader').hide();
                $('#chatInput').hide();
            }
        }
    }

    function getEmptyUsersHTML() {
        return `
            <div class="text-center text-muted py-4">
                <i class="fas fa-users fa-2x mb-2 opacity-50"></i>
                <p class="mb-0">Tidak ada pengguna lain</p>
            </div>
        `;
    }

    function getUserItemHTML(user) {
        const statusClass = user.is_online ? 'online-indicator' : 'offline-indicator';
        const statusText = user.is_online ? 'Online' : 'Offline';
        const unreadBadge = user.unread_count > 0 ? 
            `<div class="unread-count">${user.unread_count}</div>` : '';
        
        return `
            <div class="user-item" data-user-id="${user.id}">
                <div class="d-flex align-items-center position-relative">
                    <div class="avatar me-3">
                        <i class="fas fa-user-circle fa-2x text-primary"></i>
                        <div class="${statusClass}"></div>
                        ${unreadBadge}
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1 text-truncate">${user.name}</h6>
                        <small class="text-muted d-block text-truncate">${user.email}</small>
                        <small class="text-muted">${statusText} - ${user.last_seen}</small>
                    </div>
                </div>
            </div>
        `;
    }

    function showUsersError() {
        $('#usersList').html(`
            <div class="text-center text-danger py-4">
                <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                <p class="mb-0">Gagal memuat daftar pengguna</p>
            </div>
        `);
    }

    function loadMessages(userId) {
        $.get('/api/chat/messages', { receiver_id: userId })
            .done(function(messages) {
                renderMessages(messages);
            })
            .fail(function() {
                showMessagesError();
            });
    }

    function renderMessages(messages) {
        let html = '';
        
        if (messages.length === 0) {
            html = getEmptyMessagesHTML();
        } else {
            messages.forEach(function(message) {
                html += getMessageHTML(message);
            });
        }
        
        $('#chatMessages').html(html);
        scrollToBottom();
    }

    function getEmptyMessagesHTML() {
        return `
            <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                <div class="text-center">
                    <i class="fas fa-comment-slash fa-3x mb-3 opacity-50"></i>
                    <h6>Belum ada pesan</h6>
                    <p class="mb-0">Mulai percakapan dengan mengirim pesan pertama</p>
                </div>
            </div>
        `;
    }

    function getMessageHTML(message) {
        const isSent = message.sender_id == {{ Auth::id() }};
        const messageClass = isSent ? 'sent' : 'received';
        const time = formatMessageTime(message.created_at);
        const statusIcon = isSent ? getMessageStatusIcon(message.status) : '';
        
        return `
            <div class="message ${messageClass}">
                <div class="message-content">
                    <div>${formatMessage(message.message)}</div>
                    <div class="message-time">${time}</div>
                    ${statusIcon ? `<div class="message-status">${statusIcon}</div>` : ''}
                </div>
            </div>
        `;
    }

    function formatMessageTime(createdAt) {
        return new Date(createdAt).toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    function getMessageStatusIcon(status) {
        const statusIcons = {
            'sent': '<i class="fas fa-check status-sent" title="Terkirim"></i>',
            'delivered': '<i class="fas fa-check-double status-delivered" title="Terkirim"></i>',
            'read': '<i class="fas fa-check-double status-read" title="Dibaca"></i>'
        };
        
        return statusIcons[status] || '';
    }

    function showMessagesError() {
        $('#chatMessages').html(`
            <div class="d-flex align-items-center justify-content-center h-100 text-danger">
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                    <h6>Gagal memuat pesan</h6>
                    <p class="mb-0">Silakan coba lagi</p>
                </div>
            </div>
        `);
    }
    
    function sendMessage() {
        const message = $('#messageInput').val().trim();
        
        if (!message || !selectedUserId) {
            return;
        }
        
        $('#sendBtn').prop('disabled', true);
        
        $.post('/api/chat/send', {
            receiver_id: selectedUserId,
            message: message,
            _token: $('meta[name="csrf-token"]').attr('content')
        })
        .done(function(response) {
            if (response.success) {
                $('#messageInput').val('');
                loadMessages(selectedUserId);
            }
        })
        .always(function() {
            $('#sendBtn').prop('disabled', false);
        });
    }
    
    function handleUserSearch() {
        let debounceTimer = null;
        $('#userSearch').on('input', function() {
            clearTimeout(debounceTimer);
            const v = $(this).val();
            debounceTimer = setTimeout(function() {
                currentSearchTerm = (v || '').toLowerCase();
                renderUsersList(allUsers);
            }, 200);
        });
    }
    
    function handleUserSelection() {
        $(document).on('click', '.user-item', function() {
            const userId = $(this).data('user-id');
            const userName = $(this).find('h6').text();
            const userEmail = $(this).find('small').first().text();
            const isOnline = $(this).find('.online-indicator').length > 0;
            
            selectUser(userId, userName, userEmail, isOnline);
        });
    }

    function selectUser(userId, userName, userEmail, isOnline) {
        selectedUserId = userId;
        
        updateUserSelectionUI(userName, userEmail, isOnline);
        
        $('#chatHeader').show();
        $('#chatInput').show();
        
        loadMessages(userId);
        markMessagesAsRead(userId);
    }

    function updateUserSelectionUI(userName, userEmail, isOnline) {
        $('.user-item').removeClass('active');
        $(`.user-item[data-user-id="${selectedUserId}"]`).addClass('active');
        
        $('#selectedUserName').text(userName);
        $('#selectedUserEmail').text(userEmail);
        
        const statusClass = isOnline ? 'bg-success' : 'bg-secondary';
        const statusText = isOnline ? 'Online' : 'Offline';
        
        $('#userStatus')
            .text(statusText)
            .removeClass('bg-success bg-secondary')
            .addClass(statusClass);
        
        $('#headerUserStatus')
            .removeClass('bg-success bg-secondary')
            .addClass(statusClass);
    }

    function markMessagesAsRead(userId) {
        $.post('/api/chat/mark-read', {
            receiver_id: userId,
            _token: $('meta[name="csrf-token"]').attr('content')
        });
    }

    function handleMessageForm() {
        $('#messageForm').on('submit', function(e) {
            e.preventDefault();
            sendMessage();
        });

        $('#messageInput').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                sendMessage();
            }
        });
    }
    
    function startMessageRefresh() {
        if (messageInterval) clearInterval(messageInterval);
        
        messageInterval = setInterval(function() {
            if (selectedUserId) {
                loadMessages(selectedUserId);
            }
            loadUsers();
        }, 3000);
    }

    function startLastSeenUpdate() {
        if (lastSeenInterval) clearInterval(lastSeenInterval);
        lastSeenInterval = setInterval(updateLastSeen, 30000);
    }

    function handleWindowFocus() {
        $(window).on('focus', updateLastSeen);
    }

    function handlePageUnload() {
        $(window).on('beforeunload', updateLastSeen);
    }

    function handleVisibilityChange() {
        document.addEventListener('visibilitychange', function() {
            updateLastSeen();
            
            if (!document.hidden && selectedUserId) {
                loadMessages(selectedUserId);
            }
        });
    }
    
    function initializeChat() {
        loadUsers();
        updateLastSeen();
        
        startMessageRefresh();
        startLastSeenUpdate();
        
        handleUserSearch();
        handleUserSelection();
        handleMessageForm();
        handleWindowFocus();
        handlePageUnload();
        handleVisibilityChange();
    }
    initializeChat();

    $('#emojiBtn').on('click', function() {
        $('#emojiPicker').toggle();
    });

    const picker = document.querySelector('emoji-picker');
    if (picker) {
        picker.addEventListener('emoji-click', event => {
            const emoji = event.detail.unicode;
            const input = $('#messageInput');
            input.val(input.val() + emoji);
            input.focus();
        });
    }

    $(document).on('click', function(e) {
        if (!$(e.target).closest('#emojiBtn, #emojiPicker').length) {
            $('#emojiPicker').hide();
        }
    });

});
</script>
@endpush