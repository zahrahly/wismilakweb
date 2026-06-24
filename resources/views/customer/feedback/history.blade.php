@extends('layouts.customer')

@section('title','Riwayat Feedback')

@section('content')

<div style="max-width:900px;margin:auto;padding:2rem;">

<h1 class="font-serif"
style="font-size:2rem;margin-bottom:1.5rem;">

Riwayat Feedback Anda

</h1>


@forelse($feedbacks as $feedback)

<div style="
background:rgba(255,255,255,.04);
border:1px solid rgba(255,255,255,.08);
border-radius:12px;
padding:1.25rem;
margin-bottom:1rem;
">

<h3 style="color:#D4AF37;font-size:1rem;">

{{ $feedback->event->title }}

</h3>


<p style="font-size:.8rem;color:rgba(245,235,224,.4);">

Rating:
{{ $feedback->rating }}/5

</p>


@if($feedback->comment)

<p style="margin-top:.5rem;font-size:.9rem;">

{{ $feedback->comment }}

</p>

@endif


<p style="
margin-top:.5rem;
font-size:.75rem;
color:#10B981;
">

+{{ $feedback->points_awarded }} poin

</p>

</div>


@empty

<p style="color:rgba(245,235,224,.4);">

Belum ada feedback yang diberikan.

</p>

@endforelse


</div>

@endsection