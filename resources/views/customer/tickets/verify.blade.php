@extends('layouts.customer')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-black text-white">

<div class="bg-[#1C0F06] border border-[#D4AF37]/20 rounded-2xl p-10 text-center">

<h2 class="text-2xl text-[#D4AF37] mb-4">
Ticket Verification
</h2>

<p class="mb-2">
Event: {{ $ticket->event->title }}
</p>

<p class="mb-2">
Participant: {{ $ticket->full_name }}
</p>

<p class="mb-2">
Ticket Number: {{ $ticket->ticket_number }}
</p>

<p class="text-green-400 font-bold mt-4">
VALID TICKET
</p>

</div>

</div>

@endsection