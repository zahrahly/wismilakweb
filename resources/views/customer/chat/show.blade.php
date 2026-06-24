@extends('layouts.customer')

@section('title', 'The Concierge | Live Connect')

@push('styles')
<style>
    /* ── SIMPLE MINIMAL LUXURY CHAT ── */
    html, body {
        height: 100vh;
        overflow: hidden;
        background-color: #060504;
    }

    .chat-wrapper {
        height: calc(100vh - 7rem);
        display: flex;
        flex-direction: column;
        max-width: 800px;
        margin: 0 auto;
        overflow: hidden;
        box-sizing: border-box;
        padding-left: 1rem;
        padding-right: 1rem;
    }

    /* Minimal Header */
    .chat-header {
        padding: 1.5rem 0;
        text-align: center;
        border-bottom: 1px solid rgba(203, 163, 101, 0.15);
        margin-bottom: 0;
        flex-shrink: 0;
    }

    .chat-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.75rem;
        color: #cba365;
        font-weight: 400;
        letter-spacing: 0.05em;
    }

    .chat-mode-indicator {
        margin-top: 0.5rem;
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        color: #b3a89e;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    .status-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
    }
    .status-dot.bot { background: #cba365; }
    .status-dot.live { background: #10B981; }

    /* Messages Area */
    .chat-messages {
        flex: 1;
        min-height: 0;
        overflow-y: auto;
        padding: 1.5rem 0.5rem 1.5rem 0.5rem;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    /* Scrollbar - thin elegant look */
    .chat-messages::-webkit-scrollbar { width: 4px; }
    .chat-messages::-webkit-scrollbar-track { background: transparent; }
    .chat-messages::-webkit-scrollbar-thumb { background: rgba(203, 163, 101, 0.2); border-radius: 4px; }
    .chat-messages::-webkit-scrollbar-thumb:hover { background: rgba(203, 163, 101, 0.4); }

    /* Clean Message Bubbles */
    .msg-wrapper {
        display: flex;
        flex-direction: column;
        max-width: 75%;
    }
    .msg-wrapper.user { align-self: flex-end; align-items: flex-end; }
    .msg-wrapper.concierge { align-self: flex-start; align-items: flex-start; }

    .msg {
        font-size: 1.05rem;
        line-height: 1.8;
        white-space: pre-wrap;
        font-family: 'Inter', sans-serif;
        font-weight: 300;
    }

    .msg-user .msg {
        color: #f4f1eb;
        text-align: right;
    }

    .msg-concierge .msg {
        color: #b3a89e;
        text-align: left;
    }

    .msg-sender-name {
        font-family: 'Playfair Display', serif;
        color: #cba365;
        font-size: 1rem;
        margin-bottom: 0.25rem;
        font-style: italic;
    }

    .msg-time {
        font-size: 0.65rem;
        color: rgba(179, 168, 158, 0.4);
        margin-top: 0.5rem;
        letter-spacing: 0.1em;
    }

    /* Minimal Input Area */
    .chat-input-wrapper {
        padding: 1.25rem 0;
        border-top: 1px solid rgba(203, 163, 101, 0.15);
        background: #060504;
        flex-shrink: 0;
    }

    .chat-input-container {
        display: flex;
        align-items: flex-end;
        gap: 1rem;
    }

    .chat-input {
        flex: 1;
        background: transparent;
        border: none;
        border-bottom: 1px solid rgba(203, 163, 101, 0.3);
        color: #f4f1eb;
        outline: none;
        font-size: 1rem;
        padding: 0.5rem 0;
        transition: border-color 0.3s ease;
        font-weight: 300;
        resize: none;
    }
    .chat-input:focus {
        border-color: #cba365;
    }
    .chat-input::placeholder { color: rgba(244, 241, 235, 0.2); }

    .chat-send {
        background: transparent;
        border: none;
        color: #cba365;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        font-size: 0.75rem;
        cursor: pointer;
        transition: color 0.3s ease;
        padding-bottom: 0.5rem;
    }
    .chat-send:hover { color: #f4f1eb; }

    .btn-request-admin {
        background: transparent;
        border: none;
        color: rgba(179, 168, 158, 0.5);
        text-transform: uppercase;
        letter-spacing: 0.2em;
        font-size: 0.6rem;
        cursor: pointer;
        transition: color 0.3s ease;
        margin-top: 1rem;
        display: block;
        text-align: center;
        width: 100%;
    }
    .btn-request-admin:hover {
        color: #cba365;
    }

    /* Mobile responsive */
    @media (max-width: 640px) {
        .chat-wrapper {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        .chat-title { font-size: 1.25rem; }
        .chat-header { padding: 1rem 0; }
        .msg-wrapper { max-width: 85%; }
        .msg { font-size: 0.95rem; }
    }

</style>
@endpush

@section('content')
<div class="chat-wrapper">
    
    <!-- Minimal Header -->
    <div class="chat-header">
        <h2 class="chat-title">The Concierge</h2>
        <div class="chat-mode-indicator">
            <span class="status-dot {{ $session->mode === 'bot' ? 'bot' : 'live' }}"></span>
            {{ $session->mode === 'bot' ? 'Automated Assistant' : 'Human Concierge Active' }}
        </div>
    </div>

    <!-- Messages Area -->
    <div class="chat-messages" id="chatMessages">
        @foreach($session->messages as $msg)
            <div class="msg-wrapper {{ $msg->sender === 'user' ? 'user' : 'concierge' }}">
                @if($msg->sender !== 'user')
                    <div class="msg-sender-name">
                        {{ $msg->sender === 'admin' ? 'Concierge' : 'Assistant' }}
                    </div>
                @endif
                <div class="msg">
                    {{ $msg->message }}
                </div>
                <div class="msg-time">{{ $msg->created_at->format('H:i') }}</div>
            </div>
        @endforeach
    </div>

    <!-- Minimal Input Area -->
    <div class="chat-input-wrapper">
        <form method="POST" action="{{ route('customer.chat.send', $session) }}" id="chatForm">
            @csrf
            <div class="chat-input-container">
                <input type="text" name="message" class="chat-input" placeholder="Type your message..." autocomplete="off" required id="msgInput">
                <button type="submit" class="chat-send">Send</button>
            </div>
        </form>

        @if($session->isBot())
        <form method="POST" action="{{ route('customer.chat.request-admin', $session) }}">
            @csrf
            <button type="submit" class="btn-request-admin">
                Request Human Assistance
            </button>
        </form>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Auto scroll to bottom
        const chatBox = document.getElementById('chatMessages');
        chatBox.scrollTop = chatBox.scrollHeight;

        // Polling for new messages (every 3 seconds) if Live
        @if($session->isLive())
        setInterval(() => {
            fetch('{{ route("customer.chat.messages", $session) }}')
                .then(r => r.json())
                .then(data => {
                    const currentCount = chatBox.children.length;
                    if (data.messages.length > currentCount) {
                        location.reload();
                    }
                });
        }, 3000);
        @endif
    });
</script>
@endpush
