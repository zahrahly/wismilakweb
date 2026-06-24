@extends('layouts.customer')

@section('title', $page->title . ' | Wismilak')

@push('styles')
<style>
    .page-hero {
        position: relative;
        width: 100%;
        height: 60vh;
        min-height: 400px;
        background-color: #111;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        @if($page->featured_image)
        background-image: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.7)), url('{{ Storage::url($page->featured_image) }}');
        @else
        background-image: linear-gradient(to bottom, rgba(0,0,0,0.5), rgba(0,0,0,0.9));
        @endif
        background-size: cover;
        background-position: center;
    }

    .page-hero-content {
        position: relative;
        z-index: 10;
        text-align: center;
        max-width: 800px;
        padding: 0 20px;
    }

    .page-title {
        font-family: 'Playfair Display', serif;
        font-size: 3.5rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 20px;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .page-excerpt {
        font-family: 'Inter', sans-serif;
        font-size: 1.2rem;
        color: rgba(255, 255, 255, 0.8);
        line-height: 1.6;
        font-weight: 300;
    }

    .section-block {
        padding: 80px 0;
        position: relative;
        display: flex;
        align-items: center;
    }

    .section-block:nth-child(even) {
        background-color: #fafaef;
        flex-direction: row-reverse;
    }

    .section-block:nth-child(odd) {
        background-color: #ffffff;
    }

    .section-content {
        padding: 40px;
        flex: 1;
        max-width: 600px;
    }

    .section-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        font-weight: 600;
        color: #212121;
        margin-bottom: 24px;
        position: relative;
    }

    .section-title::after {
        content: '';
        display: block;
        width: 60px;
        height: 3px;
        background-color: #D4AF37; /* Gold */
        margin-top: 15px;
    }

    .section-body {
        font-family: 'Inter', sans-serif;
        font-size: 1.1rem;
        line-height: 1.8;
        color: #555;
    }

    .section-image-wrapper {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px;
    }

    .section-image {
        max-width: 100%;
        height: auto;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        border-radius: 8px;
    }

    /* Standard content block */
    .standard-content {
        max-width: 800px;
        margin: 60px auto;
        padding: 0 20px;
        font-family: 'Inter', sans-serif;
        font-size: 1.1rem;
        line-height: 1.8;
        color: #444;
    }
    
    .standard-content p {
        margin-bottom: 20px;
    }

    @media(max-width: 768px) {
        .section-block, .section-block:nth-child(even) {
            flex-direction: column;
            padding: 40px 20px;
        }
        .page-title {
            font-size: 2.5rem;
        }
        .section-content {
            padding: 20px 0;
        }
        .section-image-wrapper {
            padding: 20px 0;
        }
    }
</style>
@endpush

@section('content')

    <!-- Hero Area -->
    <div class="page-hero">
        <div class="page-hero-content">
            <h1 class="page-title">{{ $page->title }}</h1>
            @if($page->excerpt)
                <p class="page-excerpt">{{ $page->excerpt }}</p>
            @endif
        </div>
    </div>

    <!-- Optional Standard Content from TinyMCE/Direct input -->
    @if($page->content)
    <div class="standard-content text-editor-content">
        {!! $page->content !!}
    </div>
    @endif

    <!-- Dynamic Modular Sections -->
    @if($page->sections && $page->sections->count() > 0)
        <div class="dynamic-sections">
            @foreach($page->sections as $section)
            <div class="section-block {{ $loop->index % 2 == 0 ? 'even' : 'odd' }}">
                <div class="container mx-auto flex flex-col md:flex-row {{ $loop->index % 2 == 0 ? '' : 'md:flex-row-reverse' }} items-center">
                    
                    <div class="section-content w-full md:w-1/2">
                        <h2 class="section-title">{{ $section->section_title }}</h2>
                        @if($section->section_content)
                        <div class="section-body text-editor-content">
                            {!! nl2br(e($section->section_content)) !!}
                        </div>
                        @endif
                    </div>

                    @if($section->image)
                    <div class="section-image-wrapper w-full md:w-1/2">
                        <img src="{{ Storage::url($section->image) }}" alt="{{ $section->section_title }}" class="section-image">
                    </div>
                    @endif
                    
                </div>
            </div>
            @endforeach
        </div>
    @endif

@endsection

