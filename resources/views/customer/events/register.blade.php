@extends('layouts.customer')

@section('title', 'Register — ' . $event->title)

@push('styles')
<style>
:root {
    --rg-black: #060504;
    --rg-dark: #0d0805;
    --rg-card: #120e0a;
    --rg-gold: #d4af37;
    --rg-gold-dim: rgba(212,175,55,0.4);
    --rg-cream: #f4f1eb;
    --rg-text: #a8a096;
    --rg-border: rgba(212,175,55,0.12);
    --rg-serif: 'Playfair Display', serif;
    --rg-sans: 'Inter', sans-serif;
}

/* Hero */
.rg-hero {
    padding: 7rem 0 2.5rem;
    text-align: center;
    background: var(--rg-dark);
    position: relative;
}
.rg-hero::after {
    content: '';
    position: absolute; bottom: 0; left: 10%; right: 10%; height: 1px;
    background: linear-gradient(90deg, transparent, var(--rg-gold-dim), transparent);
}
.rg-hero-label {
    display: inline-flex; align-items: center; gap: 12px;
    font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.3em;
    color: var(--rg-gold); font-weight: 600; margin-bottom: 1rem;
}
.rg-hero-label::before, .rg-hero-label::after {
    content: ''; width: 25px; height: 1px; background: var(--rg-gold);
}
.rg-hero h1 {
    font-family: var(--rg-serif); color: var(--rg-cream);
    font-size: clamp(1.5rem, 3vw, 2.2rem); font-weight: 400; margin: 0 0 0.8rem;
}
.rg-hero-meta {
    color: var(--rg-text); font-size: 0.85rem; margin-bottom: 0.5rem;
}
.rg-hero-quota {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(212,175,55,0.08); border: 1px solid var(--rg-border);
    padding: 8px 20px; border-radius: 100px; margin-top: 1rem;
    font-size: 0.8rem; color: var(--rg-text);
}
.rg-hero-quota strong { color: var(--rg-gold); }

/* Layout */
.rg-container {
    max-width: 800px; margin: 0 auto; padding: 3rem 2rem 6rem;
}

/* Alerts */
.rg-alert {
    padding: 14px 20px; border-radius: 10px; margin-bottom: 1.5rem;
    font-size: 0.85rem; border: 1px solid;
}
.rg-alert.error {
    background: rgba(200,60,60,0.08); border-color: rgba(200,60,60,0.25); color: #d46b6b;
}
.rg-alert ul { margin: 6px 0 0; padding-left: 18px; }
.rg-alert li { margin-bottom: 4px; }

/* Ticket Card */
.rg-ticket {
    background: var(--rg-card); border: 1px solid var(--rg-border);
    border-radius: 14px; padding: 2rem; margin-bottom: 1.5rem;
    position: relative; transition: border-color 0.3s;
}
.rg-ticket:hover { border-color: rgba(212,175,55,0.25); }
.rg-ticket-header {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 1.5rem; padding-bottom: 1rem;
    border-bottom: 1px solid var(--rg-border);
}
.rg-ticket-title {
    font-family: var(--rg-serif); font-size: 1.1rem;
    color: var(--rg-gold); font-weight: 400;
}
.rg-ticket-remove {
    background: none; border: 1px solid rgba(200,60,60,0.3);
    color: #c8534f; font-size: 0.72rem; padding: 4px 14px;
    border-radius: 100px; cursor: pointer; transition: all 0.2s;
    text-transform: uppercase; letter-spacing: 0.1em;
}
.rg-ticket-remove:hover { background: rgba(200,60,60,0.15); border-color: #c8534f; }

/* Form Fields */
.rg-field { margin-bottom: 1.2rem; }
.rg-field label {
    display: block; font-size: 0.75rem; color: var(--rg-text);
    text-transform: uppercase; letter-spacing: 0.12em;
    margin-bottom: 8px; font-weight: 500;
}
.rg-input {
    width: 100%; padding: 12px 16px;
    background: rgba(0,0,0,0.4);
    border: 1px solid rgba(212,175,55,0.15);
    border-radius: 8px; color: var(--rg-cream);
    font-size: 0.88rem; outline: none;
    transition: border-color 0.25s, box-shadow 0.25s;
    font-family: var(--rg-sans);
}
.rg-input:focus {
    border-color: var(--rg-gold);
    box-shadow: 0 0 0 3px rgba(212,175,55,0.08);
}
.rg-input::placeholder { color: rgba(168,160,150,0.35); }
.rg-input[type="file"] { padding: 10px 12px; font-size: 0.82rem; }
.rg-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

/* Add Ticket Button */
.rg-add-btn {
    display: block; width: 100%; padding: 16px;
    background: transparent; border: 1.5px dashed rgba(212,175,55,0.25);
    border-radius: 14px; color: var(--rg-gold);
    font-size: 0.85rem; font-weight: 500; cursor: pointer;
    transition: all 0.3s; margin-bottom: 2.5rem;
    letter-spacing: 0.05em;
}
.rg-add-btn:hover { border-color: var(--rg-gold); background: rgba(212,175,55,0.04); }
.rg-add-btn:disabled { opacity: 0.35; cursor: not-allowed; }

/* Voucher Section */
.rg-voucher-section {
    background: var(--rg-card); border: 1px solid var(--rg-border);
    border-radius: 14px; padding: 2rem; margin-bottom: 2.5rem;
}
.rg-voucher-title {
    font-family: var(--rg-serif); color: var(--rg-gold);
    font-size: 1.05rem; font-weight: 400; margin: 0 0 1.5rem;
}
.rg-voucher-item {
    display: flex; justify-content: space-between; align-items: center;
    background: rgba(0,0,0,0.3); border: 1px solid rgba(212,175,55,0.1);
    border-radius: 10px; padding: 14px 18px; margin-bottom: 10px;
    transition: border-color 0.2s;
}
.rg-voucher-item:hover { border-color: rgba(212,175,55,0.3); }
.rg-voucher-code { color: var(--rg-gold); font-weight: 600; font-size: 0.95rem; }
.rg-voucher-info { color: var(--rg-text); font-size: 0.8rem; margin-top: 2px; }
.rg-voucher-exp { color: #c8534f; font-size: 0.72rem; margin-top: 3px; }
.rg-voucher-apply {
    background: var(--rg-gold); color: var(--rg-black);
    border: none; padding: 8px 20px; border-radius: 100px;
    font-size: 0.78rem; font-weight: 600; cursor: pointer;
    transition: all 0.2s; flex-shrink: 0;
}
.rg-voucher-apply:hover { box-shadow: 0 4px 15px rgba(212,175,55,0.3); }
.rg-voucher-input-row { display: flex; gap: 10px; }
.rg-voucher-msg { font-size: 0.82rem; margin-top: 10px; }

/* Reward Section */
.rg-reward-section {
    background: var(--rg-card); border: 1px solid rgba(212,175,55,0.18);
    border-radius: 14px; padding: 2rem; margin-bottom: 2.5rem;
}
.rg-reward-title {
    font-family: var(--rg-serif); color: var(--rg-gold);
    font-size: 1.05rem; font-weight: 400; margin: 0 0 0.5rem;
}
.rg-reward-subtitle {
    font-size: 0.78rem; color: var(--rg-text); margin-bottom: 1.5rem;
}
.rg-reward-item {
    display: flex; justify-content: space-between; align-items: center;
    background: rgba(0,0,0,0.3); border: 2px solid rgba(212,175,55,0.1);
    border-radius: 12px; padding: 14px 18px; margin-bottom: 10px;
    cursor: pointer; transition: all 0.25s;
}
.rg-reward-item:hover { border-color: rgba(212,175,55,0.35); background: rgba(212,175,55,0.03); }
.rg-reward-item.selected {
    border-color: var(--rg-gold); background: rgba(212,175,55,0.06);
    box-shadow: 0 0 0 3px rgba(212,175,55,0.1);
}
.rg-reward-name { color: var(--rg-gold); font-weight: 600; font-size: 0.95rem; }
.rg-reward-meta { color: var(--rg-text); font-size: 0.78rem; margin-top: 3px; }
.rg-reward-badge {
    font-size: 0.65rem; font-weight: 700; padding: 3px 10px;
    border-radius: 100px; text-transform: uppercase; letter-spacing: 0.08em;
    flex-shrink: 0;
}
.rg-reward-badge.pending { background: rgba(245,158,11,0.1); color: #f59e0b; border: 1px solid rgba(245,158,11,0.2); }
.rg-reward-badge.approved { background: rgba(16,185,129,0.1); color: #10B981; border: 1px solid rgba(16,185,129,0.2); }

/* Total & Submit */
.rg-total {
    text-align: center; padding: 2rem 0; margin-bottom: 1rem;
    border-top: 1px solid var(--rg-border);
    border-bottom: 1px solid var(--rg-border);
}
.rg-total-label { color: var(--rg-text); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.15em; margin-bottom: 8px; }
.rg-total-amount { font-family: var(--rg-serif); font-size: 2rem; color: var(--rg-gold); }
.rg-submit {
    display: block; width: 100%; padding: 16px;
    background: var(--rg-gold); color: var(--rg-black);
    border: none; border-radius: 100px;
    font-size: 0.9rem; font-weight: 600; letter-spacing: 0.08em;
    cursor: pointer; transition: all 0.3s; margin-top: 1.5rem;
}
.rg-submit:hover { box-shadow: 0 8px 30px rgba(212,175,55,0.35); transform: translateY(-2px); }

@media (max-width: 640px) {
    .rg-grid { grid-template-columns: 1fr; }
    .rg-ticket { padding: 1.5rem; }
}
</style>
@endpush

@section('content')

<!-- Hero -->
<div class="rg-hero">
    <div style="max-width: 800px; margin: 0 auto; padding: 0 2rem;">
        <span class="rg-hero-label">Event Registration</span>
        <h1>{{ $event->title }}</h1>
        <p class="rg-hero-meta">
            {{ \Carbon\Carbon::parse($event->date)->format('d F Y') }}
            &middot; {{ $event->location }}
        </p>
        <div class="rg-hero-quota">
            Remaining Quota: <strong>{{ $event->computed_remaining_quota }}</strong>
        </div>
    </div>
</div>

<div class="rg-container"
     x-data="ticketForm({{ $event->price ?? 0 }}, {{ $event->computed_remaining_quota }})">

    @if(session('error'))
    <div class="rg-alert error">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
    <div class="rg-alert error">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
    @endif

    <form method="POST"
          action="{{ route('event.register.store', $event) }}"
          enctype="multipart/form-data">
        @csrf

        <!-- Ticket Cards -->
        <template x-for="(ticket, index) in tickets" :key="index">
        <div class="rg-ticket">
            <div class="rg-ticket-header">
                <span class="rg-ticket-title">Participant <span x-text="index + 1"></span></span>
                <button type="button" x-show="tickets.length > 1" @click="removeTicket(index)" class="rg-ticket-remove">Remove</button>
            </div>

            <div class="rg-grid">
                <div class="rg-field">
                    <label>Full Name</label>
                    <input type="text" :name="'tickets['+index+'][full_name]'" required minlength="3" class="rg-input" placeholder="Enter full name">
                </div>
                <div class="rg-field">
                    <label>Email</label>
                    <input type="email" :name="'tickets['+index+'][email]'" required class="rg-input" placeholder="email@example.com">
                </div>
                <div class="rg-field">
                    <label>Phone</label>
                    <input type="tel" :name="'tickets['+index+'][phone]'" required minlength="10" class="rg-input" placeholder="08xxxxxxxxxx">
                </div>
                <div class="rg-field">
                    <label>Date of Birth</label>
                    <input type="date" :name="'tickets['+index+'][date_of_birth]'" @change="validateAge($event.target, index)" required class="rg-input" :style="ageErrors[index] ? 'border-color:#c8534f' : ''">
                    <div x-show="ageErrors[index]" style="margin-top:6px;padding:8px 12px;background:rgba(200,60,60,0.1);border:1px solid rgba(200,60,60,0.25);border-radius:6px;color:#e06060;font-size:0.8rem;display:flex;align-items:center;gap:6px;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        <span>Peserta harus berusia minimal 21 tahun</span>
                    </div>
                </div>
                <div class="rg-field">
                    <label>KTP Number (16 digits)</label>
                    <input type="text" :name="'tickets['+index+'][ktp_number]'" pattern="[0-9]{16}" maxlength="16" required class="rg-input" placeholder="16-digit KTP number">
                </div>
                <div class="rg-field">
                    <label>Upload KTP</label>
                    <input type="file" :name="'tickets['+index+'][ktp_file]'" accept="image/png,image/jpeg" required class="rg-input">
                </div>
            </div>
        </div>
        </template>

        <!-- Add Ticket -->
        <button type="button" @click="addTicket" :disabled="tickets.length >= maxQuota" class="rg-add-btn">
            + Add Another Participant
        </button>

        <!-- Voucher Section -->
        <div class="rg-voucher-section">
            <h3 class="rg-voucher-title">Voucher Code</h3>

            @if($vouchers->count())
            <div style="margin-bottom: 1.5rem;">
                @foreach($vouchers as $voucher)
                <div class="rg-voucher-item">
                    <div>
                        <div class="rg-voucher-code">{{ $voucher->voucher_code }}</div>
                        <div class="rg-voucher-info">
                            @if($voucher->voucher->discount_type == 'percentage')
                                {{ $voucher->voucher->discount_value }}% discount
                            @else
                                Rp {{ number_format($voucher->voucher->discount_value) }} discount
                            @endif
                        </div>
                        @if($voucher->expired_at)
                        <div class="rg-voucher-exp">Expires {{ \Carbon\Carbon::parse($voucher->expired_at)->diffForHumans() }}</div>
                        @endif
                    </div>
                    <button type="button" @click="applyVoucher('{{ $voucher->voucher_code }}')" class="rg-voucher-apply">Apply</button>
                </div>
                @endforeach
            </div>
            @endif

            <div class="rg-voucher-input-row">
                <input type="text" name="voucher_code" placeholder="ENTER CODE" class="rg-input" style="flex:1; text-transform:uppercase;">
                <button type="button" @click="checkVoucher()" class="rg-voucher-apply" style="padding: 12px 24px;">Apply</button>
            </div>
            <p class="rg-voucher-msg" :class="voucherMessageClass" x-text="voucherMessage"></p>
        </div>

        <!-- Reward Merchandise Section -->
        @if($rewards->count())
        <div class="rg-reward-section">
            <h3 class="rg-reward-title">Ambil Reward Merchandise</h3>
            <p class="rg-reward-subtitle">Anda memiliki reward merchandise yang belum diklaim. Pilih reward yang ingin diambil saat event ini.</p>

            <input type="hidden" name="reward_redemption_id" :value="selectedReward">

            @foreach($rewards as $reward)
            <div class="rg-reward-item" :class="selectedReward == {{ $reward->id }} ? 'selected' : ''"
                 @click="selectedReward = (selectedReward == {{ $reward->id }}) ? null : {{ $reward->id }}">
                <div style="display:flex;align-items:center;gap:12px;">
                    @if($reward->reward->image)
                    <img src="{{ asset('storage/'.$reward->reward->image) }}" style="width:42px;height:42px;border-radius:8px;object-fit:cover;flex-shrink:0;border:1px solid rgba(212,175,55,0.15);">
                    @else
                    <div style="width:42px;height:42px;border-radius:8px;background:rgba(212,175,55,0.06);display:flex;align-items:center;justify-content:center;flex-shrink:0;border:1px solid rgba(212,175,55,0.12);">
                        <svg width="20" height="20" fill="none" stroke="rgba(212,175,55,0.5)" stroke-width="1.5" viewBox="0 0 24 24"><path d="M20 12v10H4V12M2 7h20v5H2zM12 22V7M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7zM12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/></svg>
                    </div>
                    @endif
                    <div>
                        <div class="rg-reward-name">{{ $reward->reward->title }}</div>
                        <div class="rg-reward-meta">Ditukar pada {{ $reward->created_at->format('d M Y') }}</div>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:10px;">
                    <span class="rg-reward-badge {{ $reward->status }}">{{ strtoupper($reward->status) }}</span>
                    <div style="width:20px;height:20px;border-radius:50%;border:2px solid rgba(212,175,55,0.3);display:flex;align-items:center;justify-content:center;transition:all 0.2s;"
                         :style="selectedReward == {{ $reward->id }} ? 'border-color:#d4af37;background:#d4af37' : ''">
                        <svg x-show="selectedReward == {{ $reward->id }}" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="#060504" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                </div>
            </div>
            @endforeach

            <p x-show="selectedReward" style="margin-top:12px;font-size:0.8rem;color:#10B981;display:flex;align-items:center;gap:6px;">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Reward akan disiapkan untuk Anda di event ini.
            </p>
        </div>
        @endif

        <!-- Total -->
        <div class="rg-total">
            <div class="rg-total-label">Total Payment</div>
            <div class="rg-total-amount">Rp <span x-text="totalPrice"></span></div>
        </div>

        <div style="margin-top: 1rem; text-align: center; color: #c8534f; font-size: 0.82rem; font-weight: 600; padding: 10px; background: rgba(200,60,60,0.06); border: 1px dashed rgba(200,60,60,0.25); border-radius: 8px;">
            ⚠️ Penting: Seluruh tiket yang dibeli tidak dapat dibatalkan atau dikembalikan.
        </div>

        <!-- Submit -->
        <button type="submit" class="rg-submit">Continue to Payment →</button>
    </form>
</div>

<script>
function ticketForm(price, maxQuota){
    return {
        tickets: [{}],
        ageErrors: {},
        ticketPrice: Number(price) || 0,
        maxQuota: maxQuota,
        voucherCode: '',
        voucherDiscount: 0,
        voucherMessage: '',
        voucherMessageClass: '',
        selectedReward: null,

        applyVoucher(code){
            this.voucherCode = code;
            document.querySelector('[name=voucher_code]').value = code;
            this.checkVoucher();
        },

        get totalPrice(){
            let total = this.tickets.length * this.ticketPrice;
            return Math.max(0, total - this.voucherDiscount).toLocaleString();
        },

        addTicket(){
            if(this.tickets.length < this.maxQuota) this.tickets.push({});
        },

        removeTicket(index){
            this.tickets.splice(index, 1);
        },

        validateAge(input, index){
            const birth = new Date(input.value);
            const today = new Date();
            let age = today.getFullYear() - birth.getFullYear();
            const m = today.getMonth() - birth.getMonth();
            if(m < 0 || (m === 0 && today.getDate() < birth.getDate())) age--;
            if(age < 21){
                this.ageErrors[index] = true;
                input.value = '';
            } else {
                this.ageErrors[index] = false;
            }
        },

        async checkVoucher(){
            const code = document.querySelector('[name=voucher_code]').value;
            if(!code){
                this.voucherMessage = "Please enter a voucher code.";
                this.voucherMessageClass = "color: #c8534f";
                this.voucherDiscount = 0;
                return;
            }
            try {
                const res = await fetch(`/api/vouchers/check?code=${code}&event_id={{ $event->id }}&quantity=${this.tickets.length}`);
                const data = await res.json();
                if(data.valid){
                    this.voucherMessage = "Voucher applied! Discount: Rp " + data.discount.toLocaleString();
                    this.voucherMessageClass = "color: #27ae60";
                    this.voucherDiscount = data.discount;
                } else {
                    this.voucherMessage = "Invalid or expired voucher.";
                    this.voucherMessageClass = "color: #c8534f";
                    this.voucherDiscount = 0;
                }
            } catch(err){
                this.voucherMessage = "Error validating voucher.";
                this.voucherMessageClass = "color: #c8534f";
                this.voucherDiscount = 0;
            }
        }
    }
}
</script>

@endsection
