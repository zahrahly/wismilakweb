@extends('layouts.admin')

@section('title', 'Analisis Chat')

@section('content')

<h2 class="text-2xl font-semibold mb-6">
    Analisis Live Chat
</h2>

<div class="grid grid-cols-3 gap-6 mb-8">

    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-sm text-gray-500">Total Chat</h3>
        <p class="text-2xl font-bold">{{ $total }}</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-sm text-gray-500">Open</h3>
        <p class="text-2xl font-bold text-green-600">{{ $open }}</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="text-sm text-gray-500">Closed</h3>
        <p class="text-2xl font-bold text-gray-600">{{ $closed }}</p>
    </div>

</div>

<div class="grid grid-cols-2 gap-6">

    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="font-semibold mb-4">Respon Sistem</h3>
        <p>Bot: {{ $botMessages }}</p>
        <p>Admin: {{ $adminMessages }}</p>
    </div>

    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="font-semibold mb-4">Top Keyword</h3>
        <p>Event: {{ $keywordCount['event'] }}</p>
        <p>Reward: {{ $keywordCount['reward'] }}</p>
        <p>Produk: {{ $keywordCount['produk'] }}</p>
    </div>

</div>

@endsection

