@extends('layouts.customer')

@section('content')

<section class="bg-[#0D0805] min-h-screen py-20">
<div class="max-w-3xl mx-auto px-6 text-center">

<h2 class="text-3xl text-[#D4AF37] mb-8">
Payment Summary
</h2>

<div class="bg-[#1C0F06] border border-[#D4AF37]/20 p-8 rounded-2xl text-left space-y-4">

<p class="text-gray-400">
<span class="text-xs uppercase tracking-widest text-gray-500">Event</span><br>
<span class="text-white font-semibold text-lg">{{ $registration->event->title }}</span>
</p>

<div class="grid grid-cols-2 gap-4">
    <div>
        <span class="text-xs uppercase tracking-widest text-gray-500">Jumlah Tiket</span><br>
        <span class="text-white font-semibold">{{ $registration->quantity }} tiket</span>
    </div>
    <div>
        <span class="text-xs uppercase tracking-widest text-gray-500">Harga per Tiket</span><br>
        <span class="text-white font-semibold">Rp {{ number_format($registration->ticket_price, 0, ',', '.') }}</span>
    </div>
</div>

{{-- Price Breakdown --}}
<div class="border-t border-[#D4AF37]/10 pt-4 space-y-2">

    <div class="flex justify-between text-gray-400">
        <span>Subtotal ({{ $registration->quantity }} × Rp {{ number_format($registration->ticket_price, 0, ',', '.') }})</span>
        <span>Rp {{ number_format($registration->ticket_price * $registration->quantity, 0, ',', '.') }}</span>
    </div>

    @if($registration->discount_amount > 0)
    <div class="flex justify-between text-green-400">
        <span>Diskon Voucher</span>
        <span>- Rp {{ number_format($registration->discount_amount, 0, ',', '.') }}</span>
    </div>
    @endif

    <div class="flex justify-between text-xl font-bold text-[#D4AF37] border-t border-[#D4AF37]/10 pt-2">
        <span>Total</span>
        <span>Rp {{ number_format($registration->total_amount, 0, ',', '.') }}</span>
    </div>

</div>

<!-- COUNTDOWN -->
<div class="text-center pt-4">
    <div class="text-[#F59E0B] bg-[#F59E0B]/10 border border-[#F59E0B]/20 px-4 py-2.5 rounded-xl text-center text-xs font-semibold mb-4">
        ⚠️ Penting: Seluruh tiket yang dibeli tidak dapat dibatalkan atau dikembalikan.
    </div>
    <p class="text-gray-400 text-sm">Selesaikan pembayaran dalam:</p>
    <div id="countdown"
data-expired="{{ $registration->expired_at->toIso8601String() }}"
         class="text-2xl font-bold text-red-400 mt-2">
    </div>
</div>

@if($registration->payment_status === 'pending' && $registration->snap_token)
    <div class="text-center pt-4">
        <button id="pay-button" class="bg-[#D4AF37] px-8 py-3 rounded-full text-black font-semibold hover:opacity-90 transition inline-block">
            Pay Now
        </button>
    </div>
@elseif($registration->payment_status === 'paid')
    <div class="text-green-500 font-bold mt-4 text-center">Payment Successful!</div>
@else
    <div class="text-red-500 font-bold mt-4 text-center">Payment Failed or Expired.</div>
@endif

</div>

</div>
</section>

@if(config('services.midtrans.is_production'))
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
@else
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
@endif

<script>
    const payButton = document.getElementById('pay-button');
    if (payButton) {
        payButton.addEventListener('click', function () {
            snap.pay('{{ $registration->snap_token }}', {
                onSuccess: function(result) {
window.location.href =
"{{ route('customer.payment.success', $registration->id) }}?order_id="
+ result.order_id;
                },
                onPending: function(result) {
                    alert("Waiting for your payment!"); console.log(result);
                },
                onError: function(result) {
                    alert("Payment failed!"); console.log(result);
                },
                onClose: function() {
                    alert('You closed the popup without finishing the payment');
                }
            });
        });
    }

const countdownElement = document.getElementById("countdown");
if(countdownElement){
    const expiredData = countdownElement.dataset.expired;

    if(expiredData){
        const expiredTime = new Date(expiredData).getTime();

        const timer = setInterval(function(){
            const now = new Date().getTime();
            const distance = expiredTime - now;

            if(distance <= 0){
                clearInterval(timer);
                countdownElement.innerHTML = "Payment Expired";
                if(payButton) payButton.disabled = true;
                return;
            }

            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            countdownElement.innerHTML = minutes + "m " + seconds + "s";

        }, 1000);
    }
}
</script>

@endsection
