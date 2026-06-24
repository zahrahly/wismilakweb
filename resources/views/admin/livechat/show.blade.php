@extends('layouts.admin')

@section('title', 'Detail Chat')

@push('styles')
<style>
    .chat-container {
        display: flex;
        flex-direction: column;
        height: 600px;
        background: rgba(20, 20, 27, 0.4);
        border: 1px solid var(--card-border);
        border-radius: 16px;
        overflow: hidden;
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.37);
    }
    
    .chat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 1.5rem;
        background: rgba(26, 26, 37, 0.85);
        border-bottom: 1px solid var(--card-border);
    }

    .chat-user-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .chat-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        text-transform: uppercase;
        flex-shrink: 0;
    }

    .avatar-user {
        background: rgba(255, 255, 255, 0.05);
        color: var(--text-primary);
        border: 1.5px solid var(--card-border);
    }

    .avatar-admin {
        background: linear-gradient(135deg, var(--gold), #B8860B);
        color: #000;
        box-shadow: 0 0 10px rgba(212, 175, 55, 0.3);
    }

    .avatar-bot {
        background: rgba(212, 175, 55, 0.1);
        color: var(--gold);
        border: 1.5px solid rgba(212, 175, 55, 0.4);
    }

    .chat-meta {
        display: flex;
        flex-direction: column;
    }

    .chat-meta .name {
        font-weight: 600;
        font-size: 0.95rem;
        color: var(--text-primary);
    }

    .chat-meta .email {
        font-size: 0.75rem;
        color: var(--text-secondary);
    }

    .chat-actions {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .chat-messages-area {
        flex: 1;
        overflow-y: auto;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        background: rgba(10, 10, 14, 0.3);
    }

    /* Message wrapper */
    .message-wrapper {
        display: flex;
        gap: 0.75rem;
        max-width: 80%;
    }

    .message-wrapper.msg-self {
        align-self: flex-end;
        flex-direction: row-reverse;
    }

    .message-wrapper.msg-other {
        align-self: flex-start;
    }

    /* Message bubble */
    .message-bubble {
        padding: 0.75rem 1rem;
        font-size: 0.85rem;
        line-height: 1.5;
        border-radius: 16px;
        position: relative;
        word-break: break-word;
    }

    .msg-self .message-bubble {
        background: linear-gradient(135deg, var(--gold), #B8860B);
        color: #000;
        border-top-right-radius: 4px;
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.15);
        font-weight: 500;
    }

    .msg-other-user .message-bubble {
        background: rgba(255, 255, 255, 0.05);
        color: var(--text-primary);
        border: 1px solid var(--card-border);
        border-top-left-radius: 4px;
    }

    .msg-other-bot .message-bubble {
        background: rgba(212, 175, 55, 0.06);
        color: var(--text-primary);
        border: 1.5px solid rgba(212, 175, 55, 0.25);
        border-top-left-radius: 4px;
    }

    .message-info {
        font-size: 0.65rem;
        color: var(--text-secondary);
        margin-top: 0.25rem;
        display: flex;
        gap: 0.35rem;
        align-items: center;
    }

    .msg-self .message-info {
        justify-content: flex-end;
    }

    .chat-footer {
        padding: 1rem 1.5rem;
        background: rgba(26, 26, 37, 0.85);
        border-top: 1px solid var(--card-border);
    }

    .reply-form {
        display: flex;
        gap: 0.75rem;
    }

    .reply-input {
        flex: 1;
        padding: 0.75rem 1.25rem !important;
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1.5px solid var(--card-border) !important;
        border-radius: 12px !important;
        color: var(--text-primary) !important;
        font-size: 0.85rem;
        transition: all 0.3s ease !important;
    }

    .reply-input:focus {
        border-color: var(--gold) !important;
        box-shadow: 0 0 0 3px var(--gold-dim) !important;
        background: rgba(255, 255, 255, 0.08) !important;
    }

    .btn-send {
        background: linear-gradient(135deg, var(--gold), #B8860B);
        color: #000;
        padding: 0 1.5rem;
        border-radius: 12px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s;
    }

    .btn-send:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
    }

    .btn-send:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .btn-close-session {
        background: rgba(231, 76, 76, 0.1);
        color: var(--red);
        border: 1px solid rgba(231, 76, 76, 0.3);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .btn-close-session:hover {
        background: rgba(231, 76, 76, 0.2);
        border-color: rgba(231, 76, 76, 0.5);
        color: #ff5f5f;
    }

    .status-badge {
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .status-open {
        background: rgba(16, 185, 129, 0.15);
        color: #10B981;
        border: 1px solid rgba(16, 185, 129, 0.3);
        box-shadow: 0 0 10px rgba(16, 185, 129, 0.1);
    }

    .status-closed {
        background: rgba(255, 255, 255, 0.06);
        color: var(--text-secondary);
        border: 1px solid var(--card-border);
    }

    .mode-badge {
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .mode-bot {
        background: rgba(59, 130, 246, 0.15);
        color: #3B82F6;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .mode-live {
        background: rgba(212, 175, 55, 0.15);
        color: var(--gold);
        border: 1px solid rgba(212, 175, 55, 0.3);
        box-shadow: 0 0 10px rgba(212, 175, 55, 0.1);
    }
</style>
@endpush

@section('content')

<div style="margin-bottom: 2rem;">
    <a href="{{ route('admin.messages.index') }}" style="color: var(--text-secondary); text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.5rem; transition: color 0.2s;" onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='var(--text-secondary)'">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Daftar Chat
    </a>
</div>

<div class="chat-container">
    
    <!-- Chat Header -->
    <div class="chat-header">
        <div class="chat-user-info">
            <div class="chat-avatar avatar-user">
                {{ substr($session->name ?? 'G', 0, 1) }}
            </div>
            <div class="chat-meta">
                <span class="name">{{ $session->name ?? 'Guest' }}</span>
                <span class="email">{{ $session->email ?? 'Tidak ada email' }}</span>
            </div>
        </div>
        
        <div class="chat-actions">
            <!-- Mode Badge -->
            @if($session->isBot())
                <span class="mode-badge mode-bot" title="Pertanyaan dijawab otomatis oleh Chatbot">Chatbot</span>
            @else
                <span class="mode-badge mode-live" title="Terhubung langsung dengan admin">Live Chat</span>
            @endif

            <!-- Status Badge -->
            @if($session->status == 'open')
                <span class="status-badge status-open">Open</span>
                
                <form method="POST" action="{{ route('admin.messages.close', $session->id) }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-close-session" onclick="return confirm('Tutup sesi percakapan ini?')">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Tutup Percakapan
                    </button>
                </form>
            @else
                <span class="status-badge status-closed">Closed</span>
            @endif
        </div>
    </div>

    <!-- Chat Messages Scroll Area -->
    <div class="chat-messages-area" id="chat-messages-area">
        @foreach($session->messages as $msg)
            @php
                $isSelf = $msg->sender == 'admin';
                $isBot = $msg->sender == 'bot';
            @endphp
            <div class="message-wrapper {{ $isSelf ? 'msg-self' : ($isBot ? 'msg-other msg-other-bot' : 'msg-other msg-other-user') }}">
                @if($isSelf)
                    <div class="chat-avatar avatar-admin" title="Admin">A</div>
                @elseif($isBot)
                    <div class="chat-avatar avatar-bot" title="Asisten Virtual">AV</div>
                @else
                    <div class="chat-avatar avatar-user" title="{{ $session->name ?? 'Guest' }}">{{ substr($session->name ?? 'G', 0, 1) }}</div>
                @endif
                <div>
                    <div class="message-bubble">
                        {!! nl2br(e($msg->message)) !!}
                    </div>
                    <div class="message-info">
                        <span>{{ $isSelf ? 'Admin' : ($isBot ? 'Asisten Virtual' : ($session->name ?? 'Guest')) }}</span>
                        <span>•</span>
                        <span>{{ $msg->created_at->format('H:i') }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Chat Reply Form Footer -->
    <div class="chat-footer">
        @if($session->status == 'open')
            <form method="POST" action="{{ route('admin.messages.reply', $session->id) }}" id="reply-form" class="reply-form">
                @csrf
                <input type="text" name="message" id="reply-input" placeholder="Ketik balasan pesan ke {{ $session->name ?? 'Guest' }}..." autocomplete="off" required class="reply-input">
                <button type="submit" id="btn-send" class="btn-send">
                    <span>Kirim</span>
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                </button>
            </form>
        @else
            <div style="text-align: center; padding: 0.5rem; color: var(--text-secondary); font-size: 0.85rem; font-weight: 500;">
                Percakapan ini telah ditutup. Anda tidak dapat mengirim balasan.
            </div>
        @endif
    </div>

</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const messagesArea = document.getElementById('chat-messages-area');
        const replyForm = document.getElementById('reply-form');
        const replyInput = document.getElementById('reply-input');
        const btnSend = document.getElementById('btn-send');
        const sessionId = "{{ $session->id }}";
        const sessionName = @json($session->name ?? 'Guest');
        const sessionFirstChar = sessionName ? sessionName.charAt(0).toUpperCase() : 'G';
        let lastMessageCount = {{ $session->messages->count() }};

        // Helper to scroll to bottom
        function scrollToBottom() {
            messagesArea.scrollTop = messagesArea.scrollHeight;
        }

        // Initial scroll
        scrollToBottom();

        // Fetch messages dynamically
        function fetchMessages() {
            fetch(`/admin/messages/${sessionId}/messages`)
                .then(response => response.json())
                .then(messages => {
                    if (messages.length !== lastMessageCount) {
                        renderMessages(messages);
                        lastMessageCount = messages.length;
                        scrollToBottom();
                    }
                })
                .catch(err => console.error('Error polling messages:', err));
        }

        // Render messages array
        function renderMessages(messages) {
            messagesArea.innerHTML = '';
            
            messages.forEach(msg => {
                const isSelf = msg.sender === 'admin';
                const isBot = msg.sender === 'bot';
                const wrapper = document.createElement('div');
                wrapper.classList.add('message-wrapper');
                
                let avatarHtml = '';
                let senderLabel = '';
                
                if (isSelf) {
                    wrapper.classList.add('msg-self');
                    avatarHtml = `<div class="chat-avatar avatar-admin" title="Admin">A</div>`;
                    senderLabel = 'Admin';
                } else if (isBot) {
                    wrapper.classList.add('msg-other', 'msg-other-bot');
                    avatarHtml = `<div class="chat-avatar avatar-bot" title="Asisten Virtual">AV</div>`;
                    senderLabel = 'Asisten Virtual';
                } else {
                    wrapper.classList.add('msg-other', 'msg-other-user');
                    avatarHtml = `<div class="chat-avatar avatar-user" title="${escapeHtml(sessionName)}">${sessionFirstChar}</div>`;
                    senderLabel = sessionName;
                }

                // Format time (HH:MM)
                let msgTime = '';
                try {
                    const date = new Date(msg.created_at);
                    const hours = String(date.getHours()).padStart(2, '0');
                    const minutes = String(date.getMinutes()).padStart(2, '0');
                    msgTime = `${hours}:${minutes}`;
                } catch(e) {
                    msgTime = '--:--';
                }

                wrapper.innerHTML = `
                    ${avatarHtml}
                    <div>
                        <div class="message-bubble">
                            ${escapeHtml(msg.message).replace(/\n/g, '<br>')}
                        </div>
                        <div class="message-info">
                            <span>${senderLabel}</span>
                            <span>•</span>
                            <span>${msgTime}</span>
                        </div>
                    </div>
                `;
                
                messagesArea.appendChild(wrapper);
            });
        }

        // HTML escaping helper
        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        // Form submission interceptor
        if (replyForm) {
            replyForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const messageText = replyInput.value.trim();
                if (!messageText) return;

                // Disable UI
                replyInput.disabled = true;
                btnSend.disabled = true;

                const formData = new FormData(replyForm);

                fetch(replyForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    replyInput.value = '';
                    // Re-enable UI
                    replyInput.disabled = false;
                    btnSend.disabled = false;
                    replyInput.focus();
                    
                    // Fetch messages immediately
                    fetchMessages();
                })
                .catch(err => {
                    console.error('Error sending reply:', err);
                    replyInput.disabled = false;
                    btnSend.disabled = false;
                });
            });
        }

        // Poll every 3 seconds
        setInterval(fetchMessages, 3000);
    });
</script>
@endpush
