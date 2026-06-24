<style>
/* ── CONCIERGE WIDGET STYLES ── */
.concierge-trigger {
    background: rgba(6, 5, 4, 0.85);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border: 1px solid rgba(203, 163, 101, 0.3);
    color: #cba365;
    box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
}
.concierge-trigger::before {
    content: '';
    position: absolute;
    inset: -5px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(203, 163, 101, 0.2) 0%, transparent 70%);
    animation: pulse-glow 3s infinite;
    z-index: -1;
}
@keyframes pulse-glow {
    0% { transform: scale(0.9); opacity: 0.5; }
    50% { transform: scale(1.2); opacity: 0.8; }
    100% { transform: scale(0.9); opacity: 0.5; }
}
.concierge-trigger:hover {
    transform: scale(1.05) translateY(-5px);
    background: #120e0a;
    border-color: #cba365;
}

.concierge-window {
    background: rgba(10, 8, 6, 0.95);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);
    border: 1px solid rgba(203, 163, 101, 0.15);
    box-shadow: 0 30px 60px rgba(0,0,0,0.8);
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.concierge-header {
    background: linear-gradient(to right, #120e0a, #060504);
    border-bottom: 1px solid rgba(203, 163, 101, 0.1);
    padding: 1.5rem;
    position: relative;
}
.concierge-header::after {
    content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 1px;
    background: linear-gradient(90deg, transparent, rgba(203,163,101,0.5), transparent);
}

.action-card {
    background: rgba(255,255,255,0.02);
    border: 1px solid rgba(203, 163, 101, 0.15);
    border-radius: 6px;
    padding: 1rem;
    text-align: left;
    transition: all 0.3s ease;
    cursor: pointer;
    text-decoration: none;
    display: block;
}
.action-card:hover {
    background: rgba(203, 163, 101, 0.05);
    border-color: rgba(203, 163, 101, 0.4);
    transform: translateX(5px);
}

.msg-concierge {
    background: #120e0a;
    border-left: 2px solid #cba365;
    border-radius: 4px;
    padding: 1rem;
    color: #f4f1eb;
    font-size: 0.9rem;
    margin-bottom: 1rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
}
.msg-user {
    background: transparent;
    border: 1px solid rgba(203, 163, 101, 0.2);
    border-radius: 4px;
    padding: 1rem;
    color: #cba365;
    font-size: 0.9rem;
    margin-bottom: 1rem;
    align-self: flex-end;
    max-width: 85%;
}

.concierge-input-area {
    background: #060504;
    border-top: 1px solid rgba(203, 163, 101, 0.1);
    padding: 1rem;
}
.concierge-input {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(203, 163, 101, 0.2);
    border-radius: 4px;
    color: #f4f1eb;
    padding: 0.8rem 1rem;
    width: 100%;
    outline: none;
    font-size: 0.85rem;
    transition: all 0.3s ease;
}
.concierge-input:focus {
    border-color: #cba365;
    background: rgba(255,255,255,0.05);
}

.typing-indicator span {
    display: inline-block;
    width: 4px; height: 4px;
    background: #cba365;
    border-radius: 50%;
    margin: 0 2px;
    animation: typing 1.4s infinite cubic-bezier(0.2, 0.8, 0.2, 1);
}
.typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
.typing-indicator span:nth-child(3) { animation-delay: 0.4s; }
@keyframes typing {
    0%, 100% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.5); opacity: 1; }
}

/* Scrollbar */
.concierge-body::-webkit-scrollbar { width: 4px; }
.concierge-body::-webkit-scrollbar-track { background: transparent; }
.concierge-body::-webkit-scrollbar-thumb { background: rgba(203, 163, 101, 0.3); border-radius: 2px; }

/* Login Warning */
.concierge-login-warn {
    padding: 2rem 1.5rem;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
}
.concierge-login-warn svg {
    width: 40px; height: 40px;
    color: #cba365;
    opacity: 0.6;
}
.concierge-login-warn h4 {
    color: #f0ece6;
    font-size: 1rem;
    font-weight: 500;
    margin: 0;
}
.concierge-login-warn p {
    color: #8a7e74;
    font-size: 0.82rem;
    line-height: 1.6;
    margin: 0;
}
.concierge-login-btn {
    display: inline-block;
    background: linear-gradient(135deg, #cba365, #a8863e);
    color: #0a0806;
    padding: 10px 28px;
    border-radius: 100px;
    text-decoration: none;
    font-size: 0.82rem;
    font-weight: 600;
    transition: all 0.25s;
    margin-top: 0.5rem;
}
.concierge-login-btn:hover {
    box-shadow: 0 4px 20px rgba(203,163,101,0.4);
    transform: translateY(-2px);
}
</style>

<div x-data="luxuryConcierge()" class="fixed bottom-6 right-6 z-[9999]">

    <!-- Concierge Trigger Button -->
    <button @click="toggle"
            class="concierge-trigger w-14 h-14 rounded-full flex items-center justify-center outline-none"
            aria-label="Concierge">
        <svg x-show="!isOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
        </svg>
        <svg x-show="isOpen" style="display: none;" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
        
        <!-- Glowing notification dot -->
        <span x-show="hasUnread && !isOpen" class="absolute top-1.5 right-1.5 flex h-3.5 w-3.5" style="display: none;">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-500 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-red-600 border border-black" style="box-shadow: 0 0 8px rgba(239, 68, 68, 0.8);"></span>
        </span>
    </button>

    <!-- Concierge Window -->
    <div x-show="isOpen"
         x-transition:enter="transition ease-out duration-400"
         x-transition:enter-start="opacity-0 translate-y-10 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-10 scale-95"
         class="concierge-window absolute bottom-20 right-0 w-[380px] h-[550px]"
         style="display: none;">

        <!-- Header -->
        <div class="concierge-header flex justify-between items-start">
            <div>
                <h3 class="font-serif text-[#cba365] text-xl mb-1 italic">The Concierge</h3>
                <div class="flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#cba365] animate-pulse"></span>
                    <span class="text-[0.65rem] text-[#b3a89e] tracking-[0.2em] uppercase">At Your Service</span>
                </div>
            </div>
            @auth
            <button @click="startLiveChat()" class="text-[0.65rem] border border-[#cba365] text-[#cba365] px-3 py-1 rounded-full uppercase tracking-wider hover:bg-[#cba365] hover:text-black transition cursor-pointer">Live Chat</button>
            @else
            <a href="{{ route('login') }}" class="text-[0.65rem] border border-[#cba365] text-[#cba365] px-3 py-1 rounded-full uppercase tracking-wider hover:bg-[#cba365] hover:text-black transition">Login to Chat</a>
            @endauth
        </div>

        <!-- Body -->
        <div class="concierge-body flex-1 p-6 overflow-y-auto" style="font-family: 'Inter', sans-serif;" x-show="view !== 'livechat'">
            
            <!-- Welcome View -->
            <div x-show="view === 'welcome'" x-transition.opacity>
                <div class="msg-concierge">
                    <p class="font-serif text-lg text-[#cba365] mb-2">Welcome to a refined digital experience.</p>
                    <p class="text-[#b3a89e] leading-relaxed">I am your personal guide to the world of Wismilak Premium Cigars. How may I assist your journey today?</p>
                </div>

                <div class="mt-6 space-y-3">
                    <a href="{{ route('product.index') }}" class="action-card group">
                        <h4 class="text-[#cba365] font-serif text-lg group-hover:italic transition-all">Discover Collections</h4>
                        <p class="text-[#b3a89e] text-xs mt-1">Explore our signature series and limited editions.</p>
                    </a>
                    
                    <a href="{{ route('events.index') }}" class="action-card group">
                        <h4 class="text-[#cba365] font-serif text-lg group-hover:italic transition-all">Upcoming Experiences</h4>
                        <p class="text-[#b3a89e] text-xs mt-1">Request invitations to exclusive private events.</p>
                    </a>

                    <a href="{{ route('about') }}" class="action-card group">
                        <h4 class="text-[#cba365] font-serif text-lg group-hover:italic transition-all">Our Heritage</h4>
                        <p class="text-[#b3a89e] text-xs mt-1">Learn about our mastery established in 1962.</p>
                    </a>

                    <button @click="startChat('I would like some personalized recommendations.')" class="action-card group w-full text-left">
                        <h4 class="text-[#cba365] font-serif text-lg group-hover:italic transition-all">Personalized Assistance</h4>
                        <p class="text-[#b3a89e] text-xs mt-1">Speak with the concierge directly.</p>
                    </button>
                </div>
            </div>

            <!-- Active Chat View -->
            <div x-show="view === 'chat'" x-transition.opacity class="flex flex-col">
                <template x-for="(msg, index) in messages" :key="index">
                    <div :class="msg.role === 'concierge' ? 'msg-concierge' : 'msg-user ml-auto'">
                        <p x-html="msg.content" class="leading-relaxed"></p>
                    </div>
                </template>

                <div x-show="isTyping" class="msg-concierge w-16 flex justify-center py-3">
                    <div class="typing-indicator"><span></span><span></span><span></span></div>
                </div>
            </div>

        </div>

        <!-- Input Area (Concierge) -->
        <div class="concierge-input-area" x-show="view === 'chat'" x-transition>
            <form @submit.prevent="sendMessage" class="relative">
                <input type="text" x-model="userInput" class="concierge-input" placeholder="Inquire about our selections...">
                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-[#cba365] p-2 hover:scale-110 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>
            <button @click="view = 'welcome'" class="mt-3 text-[0.65rem] text-[#b3a89e] hover:text-[#cba365] uppercase tracking-widest text-center w-full transition">← Return to Menu</button>
        </div>

        <!-- Live Chat View -->
        <div x-show="view === 'livechat'" x-transition.opacity class="flex-1 flex flex-col min-h-0" style="display:none;">
            <div class="concierge-body flex-1 overflow-y-auto p-4 flex flex-col" id="liveChatBody" style="font-family:'Inter',sans-serif;">
                <template x-for="(msg, index) in liveMessages" :key="index">
                    <div :class="msg.sender === 'user' ? 'msg-user ml-auto' : 'msg-concierge'">
                        <div x-show="msg.sender !== 'user'" style="font-size:0.6rem;color:#8a7e74;text-transform:uppercase;letter-spacing:0.1em;margin-bottom:4px;" x-text="msg.sender === 'admin' ? 'Admin' : 'Asisten'"></div>
                        <p x-text="msg.message" class="leading-relaxed" style="white-space:pre-wrap;"></p>
                    </div>
                </template>
                <div x-show="isTyping" class="msg-concierge w-16 flex justify-center py-3">
                    <div class="typing-indicator"><span></span><span></span><span></span></div>
                </div>
            </div>
            <div class="concierge-input-area">
                <form @submit.prevent="sendLiveMessage()" class="relative">
                    <input type="text" x-model="liveInput" class="concierge-input" placeholder="Ketik pesan..." x-ref="liveInput">
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-[#cba365] p-2 hover:scale-110 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
                <div class="flex gap-2 mt-2">
                    <button x-show="liveChatMode === 'bot'" @click="requestLiveAdmin()" class="flex-1 text-[0.65rem] text-[#b3a89e] hover:text-[#cba365] border border-[rgba(203,163,101,0.2)] rounded py-1.5 uppercase tracking-widest text-center transition">Hubungi Admin</button>
                    <button @click="view = 'welcome'; stopPolling()" class="flex-1 text-[0.65rem] text-[#b3a89e] hover:text-[#cba365] uppercase tracking-widest text-center transition">← Kembali</button>
                </div>
            </div>
        </div>

    </div>
</div>

@auth
<span id="concierge-live-link" style="display:none"><a href='{{ route('customer.chat.start') }}' class='text-[#cba365] underline'>Live Chat</a></span>
@else
<span id="concierge-live-link" style="display:none"><a href='{{ route('login') }}' class='text-[#cba365] underline'>Login</a> to access Live Chat</span>
@endauth

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('luxuryConcierge', () => ({
        isOpen: false,
        view: 'welcome',
        userInput: '',
        isTyping: false,
        hasUnread: false,
        liveChatLink: document.getElementById('concierge-live-link')?.innerHTML || '',
        messages: [
            { role: 'concierge', content: '<span class="font-serif text-[#cba365] text-lg block mb-2">Excellent choice.</span> How can I assist you with personalized recommendations today?' }
        ],

        // Live Chat State
        sessionId: null,
        liveMessages: [],
        liveInput: '',
        liveChatMode: 'bot',
        pollInterval: null,
        csrfToken: document.querySelector('meta[name="csrf-token"]')?.content || '',

        init() {
            @auth
                this.checkActiveSession();
            @endauth
        },

        async checkActiveSession() {
            try {
                const res = await fetch('{{ route("customer.chat.active-session") }}');
                const data = await res.json();
                if (data.session_id) {
                    this.sessionId = data.session_id;
                    await this.fetchLiveMessages();
                    this.startPolling();
                }
            } catch(e) {}
        },

        toggle() {
            this.isOpen = !this.isOpen;
            if (this.isOpen && this.view === 'livechat') {
                this.hasUnread = false;
            }
        },

        startChat(initialMessage) {
            this.view = 'chat';
        },

        // === Live Chat Methods ===
        async startLiveChat() {
            this.view = 'livechat';
            this.hasUnread = false;
            this.isTyping = true;
            try {
                const res = await fetch('{{ route("customer.chat.start") }}', {
                    method: 'GET',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    redirect: 'follow'
                });
                const url = res.url;
                const match = url.match(/messages\/(\d+)/);
                if (match) {
                    this.sessionId = match[1];
                    await this.fetchLiveMessages();
                    this.startPolling();
                }
            } catch(e) { console.error('Start session error', e); }
            this.isTyping = false;
        },

        async fetchLiveMessages() {
            if (!this.sessionId) return;
            try {
                const res = await fetch(`{{ url('/customer/messages') }}/${this.sessionId}/fetch`);
                const data = await res.json();
                
                const oldLength = this.liveMessages.length;
                this.liveMessages = data.messages || [];
                this.liveChatMode = data.mode || 'bot';
                
                if (this.liveMessages.length > 0) {
                    const lastMsg = this.liveMessages[this.liveMessages.length - 1];
                    if (lastMsg.sender !== 'user' && (!this.isOpen || this.view !== 'livechat')) {
                        this.hasUnread = true;
                    } else {
                        this.hasUnread = false;
                    }
                } else {
                    this.hasUnread = false;
                }
                
                this.$nextTick(() => this.scrollLiveChat());
            } catch(e) {}
        },

        async sendLiveMessage() {
            if (!this.liveInput.trim() || !this.sessionId) return;
            const msg = this.liveInput;
            this.liveInput = '';
            this.liveMessages.push({ sender: 'user', message: msg, created_at: new Date().toISOString() });
            this.$nextTick(() => this.scrollLiveChat());
            this.isTyping = true;
            try {
                const formData = new FormData();
                formData.append('message', msg);
                formData.append('_token', this.csrfToken);
                await fetch(`{{ url('/customer/messages') }}/${this.sessionId}/send`, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                });
                await this.fetchLiveMessages();
            } catch(e) { console.error('Send error', e); }
            this.isTyping = false;
            this.$nextTick(() => { if (this.$refs.liveInput) this.$refs.liveInput.focus(); });
        },

        async requestLiveAdmin() {
            if (!this.sessionId) return;
            try {
                const formData = new FormData();
                formData.append('_token', this.csrfToken);
                await fetch(`{{ url('/customer/messages') }}/${this.sessionId}/request-admin`, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                });
                await this.fetchLiveMessages();
            } catch(e) { console.error('Request admin error', e); }
        },

        startPolling() {
            this.stopPolling();
            // Poll regardless of window status so background notification works!
            this.pollInterval = setInterval(() => { if (this.sessionId) this.fetchLiveMessages(); }, 4000);
        },

        stopPolling() {
            if (this.pollInterval) { clearInterval(this.pollInterval); this.pollInterval = null; }
        },

        scrollLiveChat() {
            const el = document.getElementById('liveChatBody');
            if (el) el.scrollTop = el.scrollHeight;
        },

        // === Concierge Bot Methods ===
        sendMessage() {
            if (this.userInput.trim() === '') return;
            this.messages.push({ role: 'user', content: this.userInput });
            const inputTemp = this.userInput.toLowerCase();
            this.userInput = '';
            this.scrollToBottom();
            this.isTyping = true;

            setTimeout(() => {
                this.isTyping = false;
                let response = "";
                if (inputTemp.includes('recommend') || inputTemp.includes('suggest') || inputTemp.includes('cigar')) {
                    response = "I highly recommend the <strong>Premium Robusto</strong> for a refined 45-minute experience. It pairs exquisitely with an 18-year Single Malt. Shall I guide you to the <a href='{{ route('product.index') }}' class='text-[#cba365] underline'>Collections</a>?";
                } else if (inputTemp.includes('event') || inputTemp.includes('invite') || inputTemp.includes('experience')) {
                    response = "Our private experiences are strictly invitation-only. You may browse our <a href='{{ route('events.index') }}' class='text-[#cba365] underline'>Upcoming Experiences</a> to request access to the Inner Circle.";
                } else if (inputTemp.includes('lounge') || inputTemp.includes('location') || inputTemp.includes('where')) {
                    response = "Our flagship sanctuary, Grha Wismilak, is located in Surabaya. We invite you to experience absolute luxury in our dedicated lounge areas.";
                } else {
                    response = "Thank you for your inquiry. For detailed assistance, I recommend opening a " + this.liveChatLink + " with our dedicated human concierge team.";
                }
                this.messages.push({ role: 'concierge', content: response });
                this.scrollToBottom();
            }, 1500);
        },

        scrollToBottom() {
            setTimeout(() => {
                const body = document.querySelector('.concierge-body');
                if (body) body.scrollTop = body.scrollHeight;
            }, 50);
        },

        destroy() { this.stopPolling(); }
    }));
});
</script>
