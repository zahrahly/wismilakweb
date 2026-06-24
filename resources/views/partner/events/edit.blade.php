@extends('layouts.dashboard')

@section('title', 'Edit Event')

@section('sidebar')
    @include('partner.partials.sidebar')
@endsection

@section('content')
    @include('partner.events.create')
@endsection

