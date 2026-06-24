@extends('layouts.customer')

@section('title', 'Voucher Dimiliki')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 2rem;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 class="font-serif" style="font-size: 2rem; color: #D4AF37;">Voucher Dimiliki</h1>
        <a href="{{ route('customer.dashboard') }}" style="color: rgba(245,235,224,0.6); text-decoration: none;">&larr; Kembali ke Dashboard</a>
    </div>

    @if(session('success'))
        <div style="background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.3); color: #10B981; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem;">
        @forelse($vouchers as $redemption)
        <div style="background: linear-gradient(135deg, rgba(212,175,55,0.08), rgba(212,175,55,0.02)); border: 1px solid rgba(212,175,55,0.15); border-radius: 16px; padding: 1.5rem; position: relative; overflow: hidden; {{ $redemption->status == 'used' ? 'opacity: 0.6;' : '' }}">
            <div style="position:absolute; top:0; right:0; background: rgba(212,175,55,0.15); padding: 0.4rem 1rem; border-radius: 0 16px 0 12px; font-size: 0.7rem; font-weight: 600; color: #D4AF37;">
                {{ ucfirst($redemption->status) }}
            </div>
            
            <h3 style="font-size: 1.1rem; font-weight: 600; color: #D4AF37; margin-bottom: 0.5rem; margin-top: 0.5rem;">
                {{ $redemption->voucher->title }}
            </h3>
            
            <div style="background: rgba(0,0,0,0.3); border: 1px dashed rgba(212,175,55,0.4); padding: 0.75rem; border-radius: 8px; text-align: center; margin: 1rem 0;">
                <code style="font-size: 1.2rem; color: #FFF; font-weight: bold; font-family: monospace; letter-spacing: 2px;" id="code-{{ $redemption->id }}">
                    {{ $redemption->voucher_code }}
                </code>
            </div>

            <p style="font-size: 0.8rem; color: rgba(245,235,224,0.7); margin-bottom: 0.25rem;">
                Diskon: {{ $redemption->voucher->discount_type === 'percentage' ? $redemption->voucher->discount_value . '%' : 'Rp ' . number_format($redemption->voucher->discount_value, 0, ',', '.') }}
            </p>
            
            <p style="font-size: 0.75rem; color: rgba(245,235,224,0.4); margin-bottom: 1rem;">
                Berlaku hingga: {{ $redemption->expired_at ? $redemption->expired_at->format('d M Y H:i') : 'Unlimited' }}
            </p>

            @if($redemption->status == 'unused')
            <button onclick="copyToClipboard('code-{{ $redemption->id }}')" style="width: 100%; padding: 0.6rem; background: rgba(212,175,55,0.1); border: 1px solid rgba(212,175,55,0.3); color: #D4AF37; border-radius: 8px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='rgba(212,175,55,0.2)'" onmouseout="this.style.background='rgba(212,175,55,0.1)'">
                Copy Code
            </button>
            @endif
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 4rem 2rem; background: rgba(255,255,255,0.02); border-radius: 16px; border: 1px dashed rgba(255,255,255,0.1);">
            <svg style="width: 48px; height: 48px; margin: 0 auto 1rem; color: rgba(212,175,55,0.4);" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
            <h3 style="font-size: 1.2rem; color: #D4AF37; margin-bottom: 0.5rem;">Belum Ada Voucher</h3>
            <p style="color: rgba(245,235,224,0.5); margin-bottom: 1.5rem;">Tukarkan poin Anda di dashboard untuk mendapatkan voucher diskon event.</p>
            <a href="{{ route('customer.dashboard') }}" style="display: inline-block; padding: 0.6rem 1.5rem; background: #D4AF37; color: #000; font-weight: 600; text-decoration: none; border-radius: 8px;">Tukar Poin Sekarang</a>
        </div>
        @endforelse
    </div>

    <div style="margin-top: 2rem;">
        {{ $vouchers->links() }}
    </div>
</div>

<script>
    function copyToClipboard(elementId) {
        var copyText = document.getElementById(elementId).innerText.trim();
        navigator.clipboard.writeText(copyText).then(() => {
            alert("Voucher code copied to clipboard!");
        });
    }
</script>
@endsection

