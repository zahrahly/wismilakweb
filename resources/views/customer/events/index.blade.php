@extends('layouts.customer')

@section('title', 'Events — Wismilak Experiences')

@push('styles')
<style>
/* ── EVENT INDEX PREMIUM DESIGN ── */
:root {
    --ev-black: #060504;
    --ev-dark: #0d0805;
    --ev-card: #120e0a;
    --ev-gold: #d4af37;
    --ev-gold-dim: rgba(212,175,55,0.4);
    --ev-cream: #f4f1eb;
    --ev-text: #a8a096;
    --ev-border: rgba(212,175,55,0.12);
    --ev-serif: 'Playfair Display', serif;
    --ev-sans: 'Inter', sans-serif;
}

.ev-hero {
    padding: 8rem 0 3rem;
    text-align: center;
    position: relative;
    background: var(--ev-dark);
}
.ev-hero::after {
    content: '';
    position: absolute; bottom: 0; left: 10%; right: 10%; height: 1px;
    background: linear-gradient(90deg, transparent, var(--ev-gold-dim), transparent);
}
.ev-label {
    display: inline-flex; align-items: center; gap: 12px;
    font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.3em;
    color: var(--ev-gold); font-weight: 600; margin-bottom: 1.5rem;
}
.ev-label::before, .ev-label::after {
    content: ''; width: 30px; height: 1px; background: var(--ev-gold);
}
.ev-hero h1 {
    font-family: var(--ev-serif); color: var(--ev-cream); font-size: clamp(2rem, 4vw, 3.5rem);
    font-weight: 400; line-height: 1.15; margin: 0 0 1rem;
}
.ev-hero h1 em { font-style: italic; color: var(--ev-gold); }
.ev-hero-sub {
    color: var(--ev-text); max-width: 550px; margin: 0 auto 2rem;
    font-size: 0.92rem; line-height: 1.7;
}

/* Tab Switch */
.ev-tabs { display: flex; gap: 12px; justify-content: center; margin-bottom: 3rem; }
.ev-tab {
    padding: 10px 28px; border-radius: 100px;
    font-size: 0.82rem; font-weight: 500; letter-spacing: 0.05em;
    cursor: pointer; transition: all 0.35s ease; border: 1px solid transparent;
    background: transparent; color: var(--ev-text);
}
.ev-tab.active {
    background: var(--ev-gold); color: var(--ev-black);
    box-shadow: 0 4px 20px rgba(212,175,55,0.35);
}
.ev-tab:not(.active) {
    border-color: var(--ev-gold-dim); color: var(--ev-gold);
}
.ev-tab:not(.active):hover {
    border-color: var(--ev-gold); background: rgba(212,175,55,0.08);
}

/* Upcoming Highlight */
.ev-highlight {
    background: linear-gradient(135deg, var(--ev-card) 0%, #1a1410 100%);
    border: 1px solid var(--ev-border);
    border-radius: 16px; padding: 2.5rem;
    margin-bottom: 4rem;
    display: grid; grid-template-columns: 1fr auto; gap: 2rem; align-items: center;
    position: relative; overflow: hidden;
}
.ev-highlight::before {
    content: ''; position: absolute; top: -50%; right: -20%; width: 300px; height: 300px;
    background: radial-gradient(circle, rgba(212,175,55,0.06) 0%, transparent 70%);
    pointer-events: none;
}
.ev-highlight-badge {
    display: inline-flex; align-items: center; gap: 8px;
    font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.2em;
    color: var(--ev-gold); margin-bottom: 1rem;
}
.ev-highlight-badge .dot {
    width: 7px; height: 7px; border-radius: 50%; background: var(--ev-gold);
    animation: evPulse 2s infinite;
}
@keyframes evPulse { 0%,100%{opacity:.5;transform:scale(.9)} 50%{opacity:1;transform:scale(1.1)} }
.ev-highlight h2 {
    font-family: var(--ev-serif); color: var(--ev-cream);
    font-size: 1.8rem; font-weight: 400; margin: 0 0 0.5rem;
}
.ev-highlight-meta {
    color: var(--ev-text); font-size: 0.85rem; margin-bottom: 1rem;
}
.ev-highlight-meta .free { color: #27ae60; font-weight: 600; }
.ev-highlight-meta .price { color: var(--ev-gold); font-weight: 600; }
.ev-countdown {
    font-family: var(--ev-serif); font-size: 1.3rem; color: var(--ev-gold);
    margin-bottom: 1.5rem; letter-spacing: 0.05em;
}
.ev-btn {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--ev-gold); color: var(--ev-black);
    padding: 12px 28px; border-radius: 100px; text-decoration: none;
    font-size: 0.82rem; font-weight: 600; letter-spacing: 0.05em;
    transition: all 0.3s; border: none; cursor: pointer;
}
.ev-btn:hover { box-shadow: 0 6px 25px rgba(212,175,55,0.4); transform: translateY(-2px); }

/* Calendar */
.ev-cal-nav {
    display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;
}
.ev-cal-nav a {
    color: var(--ev-gold); text-decoration: none; font-size: 0.85rem;
    transition: opacity 0.2s; letter-spacing: 0.05em;
}
.ev-cal-nav a:hover { opacity: 0.7; }
.ev-cal-nav h2 {
    font-family: var(--ev-serif); color: var(--ev-cream);
    font-size: 1.5rem; font-weight: 400; letter-spacing: 0.05em;
}
.ev-cal-days {
    display: grid; grid-template-columns: repeat(7, 1fr); gap: 8px;
    text-align: center; font-size: 0.7rem; text-transform: uppercase;
    letter-spacing: 0.15em; color: rgba(168,160,150,0.5); margin-bottom: 8px;
}
.ev-cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 8px; }
.ev-cal-cell {
    min-height: 110px; background: var(--ev-card); border-radius: 10px;
    padding: 10px; border: 1px solid rgba(212,175,55,0.06);
    transition: all 0.3s;
}
.ev-cal-cell:hover { border-color: var(--ev-gold-dim); }
.ev-cal-cell.today { border-color: var(--ev-gold); box-shadow: 0 0 12px rgba(212,175,55,0.15); }
.ev-cal-cell.has-event { border-color: rgba(212,175,55,0.2); }
.ev-cal-date {
    font-size: 0.8rem; color: rgba(168,160,150,0.6); margin-bottom: 8px; font-weight: 500;
}
.ev-cal-cell.today .ev-cal-date { color: var(--ev-gold); }
.ev-cal-date .today-tag {
    font-size: 0.55rem; background: var(--ev-gold); color: var(--ev-black);
    padding: 1px 5px; border-radius: 3px; margin-left: 4px; vertical-align: middle;
}
.ev-cal-event {
    display: block; font-size: 0.7rem; padding: 4px 8px; border-radius: 6px;
    margin-bottom: 4px; text-decoration: none; transition: all 0.2s;
    overflow: hidden; white-space: nowrap; text-overflow: ellipsis;
}
.ev-cal-event.available { background: rgba(212,175,55,0.1); color: var(--ev-gold); }
.ev-cal-event.available:hover { background: var(--ev-gold); color: var(--ev-black); }
.ev-cal-event.full { background: rgba(200,60,60,0.1); color: #c8534f; }
.ev-cal-event.ended { background: rgba(120,120,120,0.1); color: #777; }

/* Event List Cards */
.ev-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 28px; }
.ev-card {
    background: var(--ev-card); border: 1px solid var(--ev-border);
    border-radius: 14px; overflow: hidden;
    transition: all 0.45s cubic-bezier(0.4,0,0.2,1);
    position: relative;
}
.ev-card:hover {
    border-color: rgba(212,175,55,0.35);
    transform: translateY(-6px);
    box-shadow: 0 20px 50px rgba(0,0,0,0.5), 0 0 30px rgba(212,175,55,0.08);
}
.ev-card-img {
    height: 220px; overflow: hidden; position: relative;
}
.ev-card-img img {
    width: 100%; height: 100%; object-fit: cover;
    transition: transform 0.7s cubic-bezier(0.4,0,0.2,1);
}
.ev-card:hover .ev-card-img img { transform: scale(1.08); }
.ev-card-img .ev-badge {
    position: absolute; top: 14px; right: 14px;
    padding: 5px 14px; border-radius: 100px;
    font-size: 0.65rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.1em; backdrop-filter: blur(8px);
}
.ev-badge.sold-out { background: rgba(200,60,60,0.85); color: #fff; }
.ev-badge.ended { background: rgba(80,80,80,0.85); color: #ccc; }
.ev-card-body { padding: 24px; }
.ev-card-date {
    font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.15em;
    color: var(--ev-gold); margin-bottom: 10px; font-weight: 500;
}
.ev-card-title {
    font-family: var(--ev-serif); color: var(--ev-cream);
    font-size: 1.25rem; font-weight: 400; margin: 0 0 8px;
    line-height: 1.3;
}
.ev-card-loc {
    color: var(--ev-text); font-size: 0.82rem; margin-bottom: 16px;
    display: flex; align-items: center; gap: 6px;
}
.ev-card-footer {
    display: flex; justify-content: space-between; align-items: center;
    padding-top: 16px; border-top: 1px solid var(--ev-border);
}
.ev-card-price { color: var(--ev-gold); font-weight: 600; font-size: 0.9rem; }
.ev-card-price.free { color: #27ae60; }
.ev-card-link {
    color: var(--ev-gold); text-decoration: none; font-size: 0.8rem;
    font-weight: 500; letter-spacing: 0.05em; transition: all 0.2s;
    display: flex; align-items: center; gap: 6px;
}
.ev-card-link:hover { gap: 10px; }

@media (max-width: 768px) {
    .ev-highlight { grid-template-columns: 1fr; }
    .ev-grid { grid-template-columns: 1fr; }
    .ev-cal-cell { min-height: 80px; padding: 6px; }
    .ev-cal-event { font-size: 0.6rem; padding: 2px 4px; }
}
</style>
@endpush

@section('content')

<section style="background: var(--ev-dark, #0d0805); padding-bottom: 6rem;">

<!-- HERO -->
<div class="ev-hero">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
        <span class="ev-label">Events</span>
        <h1>Discover Our <em>Signature</em> Events</h1>
        <p class="ev-hero-sub">Explore exclusive gatherings, premium cigar evenings, and curated experiences crafted by Wismilak.</p>

        <div class="ev-tabs" x-data="{ tab: 'calendar' }" id="evTabRoot">
            <button class="ev-tab" :class="{ active: tab === 'calendar' }" @click="tab = 'calendar'; $dispatch('ev-tab', { tab: 'calendar' })">Calendar View</button>
            <button class="ev-tab" :class="{ active: tab === 'list' }" @click="tab = 'list'; $dispatch('ev-tab', { tab: 'list' })">Event List</button>
        </div>
    </div>
</div>

<div style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;" x-data="{ tab: 'calendar' }" @ev-tab.window="tab = $event.detail.tab">

<!-- UPCOMING HIGHLIGHT -->
@php $nextEvent = $events->where('date','>=',now())->sortBy('date')->first(); @endphp
@if($nextEvent)
<div class="ev-highlight">
    <div>
        <div class="ev-highlight-badge"><span class="dot"></span> Upcoming Event</div>
        <h2>{{ $nextEvent->title }}</h2>
        <p class="ev-highlight-meta">
            {{ \Carbon\Carbon::parse($nextEvent->date)->format('d F Y') }}
            &middot; {{ $nextEvent->location }}
            @if($nextEvent->price_type === 'free')
                &middot; <span class="free">FREE</span>
            @else
                &middot; <span class="price">Rp {{ number_format($nextEvent->price) }}</span>
            @endif
        </p>
        <div class="ev-countdown" id="eventCountdown" data-date="{{ \Carbon\Carbon::parse($nextEvent->date)->toIso8601String() }}"></div>
        <a href="{{ route('events.show', $nextEvent) }}" class="ev-btn">View Details <span>→</span></a>
    </div>
</div>
@endif

<!-- CALENDAR VIEW -->
<div x-show="tab === 'calendar'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
@php
$currentMonth = $month->copy();
$startOfCalendar = $currentMonth->copy()->startOfMonth()->startOfWeek();
$endOfCalendar = $currentMonth->copy()->endOfMonth()->endOfWeek();
@endphp

<div class="ev-cal-nav">
    <a href="{{ route('events.index',['month'=>$currentMonth->copy()->subMonth()->format('Y-m')]) }}">← Previous</a>
    <h2>{{ $currentMonth->format('F Y') }}</h2>
    <a href="{{ route('events.index',['month'=>$currentMonth->copy()->addMonth()->format('Y-m')]) }}">Next →</a>
</div>

<div class="ev-cal-days">
    <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
</div>

<div class="ev-cal-grid">
@for($date = $startOfCalendar->copy(); $date <= $endOfCalendar; $date->addDay())
@php
$formatted = $date->format('Y-m-d');
$dayEvents = $eventsByDate[$formatted] ?? [];
$isToday = $date->isToday();
$hasEvents = count($dayEvents) > 0;
@endphp

<div class="ev-cal-cell {{ $isToday ? 'today' : '' }} {{ $hasEvents ? 'has-event' : '' }}">
    <div class="ev-cal-date">
        {{ $date->format('d') }}
        @if($isToday)<span class="today-tag">TODAY</span>@endif
    </div>
    @foreach($dayEvents as $event)
    @php $evtStatus = $event->public_status; @endphp
    <a href="{{ route('events.show',$event) }}"
       class="ev-cal-event {{ $evtStatus === 'Full' ? 'full' : ($evtStatus === 'Event Passed' ? 'ended' : 'available') }}">
        {{ \Illuminate\Support\Str::limit($event->title, 16) }}
        @if($evtStatus === 'Full') <small>FULL</small>@endif
    </a>
    @endforeach
</div>
@endfor
</div>
</div>

<!-- LIST VIEW -->
<div x-show="tab === 'list'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
    @php
        $upcomingList = $events->filter(fn($e) => \Carbon\Carbon::parse($e->date)->endOfDay()->isFuture() || \Carbon\Carbon::parse($e->date)->isToday());
        $pastList = $events->filter(fn($e) => \Carbon\Carbon::parse($e->date)->endOfDay()->isPast());
    @endphp

    {{-- Upcoming Events --}}
    @if($upcomingList->isNotEmpty())
        <h3 style="font-family: var(--ev-serif); color: var(--ev-cream); font-size: 1.5rem; font-weight: 400; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.6rem;">
            <span style="width: 8px; height: 8px; border-radius: 50%; background: var(--ev-gold); display: inline-block; box-shadow: 0 0 8px var(--ev-gold);"></span>
            Upcoming Events
        </h3>
        <div class="ev-grid" style="margin-bottom: 4rem;">
            @foreach($upcomingList as $event)
            @php $evtStatus = $event->public_status; @endphp
            <div class="ev-card">
                <div class="ev-card-img">
                    <img src="{{ asset('storage/'.$event->image) }}" alt="{{ $event->title }}" loading="lazy">
                    @if($evtStatus === 'Full')
                        <span class="ev-badge sold-out">Sold Out</span>
                    @elseif($evtStatus === 'Event Passed')
                        <span class="ev-badge ended">Ended</span>
                    @endif
                </div>
                <div class="ev-card-body">
                    <div class="ev-card-date">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</div>
                    <h3 class="ev-card-title">{{ $event->title }}</h3>
                    <p class="ev-card-loc">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $event->location }}
                    </p>
                    <div class="ev-card-footer">
                        <span class="ev-card-price {{ $event->price_type === 'free' ? 'free' : '' }}">
                            @if($event->price_type === 'free') FREE @else Rp {{ number_format($event->price) }} @endif
                        </span>
                        <a href="{{ route('events.show',$event) }}" class="ev-card-link">
                            View Details <span>→</span>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    {{-- Completed Events --}}
    @if($pastList->isNotEmpty())
        <h3 style="font-family: var(--ev-serif); color: var(--ev-cream); font-size: 1.5rem; font-weight: 400; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.6rem; opacity: 0.7; padding-top: 1rem;">
            <span style="width: 8px; height: 8px; border-radius: 50%; background: #888; display: inline-block;"></span>
            Completed Events
        </h3>
        <div class="ev-grid">
            @foreach($pastList as $event)
            @php $evtStatus = $event->public_status; @endphp
            <div class="ev-card" style="opacity: 0.55; border-color: rgba(255,255,255,0.05); filter: grayscale(20%);">
                <div class="ev-card-img">
                    <img src="{{ asset('storage/'.$event->image) }}" alt="{{ $event->title }}" loading="lazy">
                    <span class="ev-badge ended">Ended</span>
                </div>
                <div class="ev-card-body">
                    <div class="ev-card-date">{{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}</div>
                    <h3 class="ev-card-title" style="color: var(--ev-text);">{{ $event->title }}</h3>
                    <p class="ev-card-loc">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $event->location }}
                    </p>
                    <div class="ev-card-footer">
                        <span class="ev-card-price" style="color: var(--ev-text);">
                            @if($event->price_type === 'free') FREE @else Rp {{ number_format($event->price) }} @endif
                        </span>
                        <a href="{{ route('events.show',$event) }}" class="ev-card-link" style="color: var(--ev-text);">
                            View details <span>→</span>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

</div>
</section>

<script>
const countdownEl = document.getElementById("eventCountdown");
if(countdownEl){
    const eventTime = new Date(countdownEl.dataset.date).getTime();
    const timer = setInterval(function(){
        const now = new Date().getTime();
        const distance = eventTime - now;
        if(distance <= 0){ clearInterval(timer); countdownEl.innerHTML = "Event is happening now!"; return; }
        const d = Math.floor(distance / (1000*60*60*24));
        const h = Math.floor((distance % (1000*60*60*24)) / (1000*60*60));
        const m = Math.floor((distance % (1000*60*60)) / (1000*60));
        const s = Math.floor((distance % (1000*60)) / 1000);
        let t = '';
        if(d > 0) t += d + 'd ';
        t += h + 'h ' + m + 'm ' + s + 's';
        countdownEl.innerHTML = t;
    }, 1000);
}
</script>

@endsection
