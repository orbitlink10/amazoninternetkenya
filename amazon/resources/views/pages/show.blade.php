@extends('layouts.app')

@section('title', $page['meta_title'] ?? $page['title'])
@section('meta_description', $page['meta_description'] ?? \Illuminate\Support\Str::limit(strip_tags($page['description'] ?? ''), 155))

@push('styles')
    @once
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <style>
            .semrush-font { font-family: 'Inter', 'Manrope', system-ui, sans-serif; }
        </style>
    @endonce
@endpush

@section('content')
@php
    // Basic metadata used for badges
    $wordCount = str_word_count(strip_tags($page['description'] ?? ''));
    $readMinutes = max(1, (int) ceil($wordCount / 200));
    $published = $page['published_at'] ?? ($page['created_at'] ?? null);
    $publishedDate = $published ? \Carbon\Carbon::parse($published)->format('M d, Y') : null;
@endphp

<div class="semrush-font">
    {{-- Hero inspired by Semrush blog --}}
    <section class="relative overflow-hidden text-white" style="background: linear-gradient(180deg, #017f74 0%, #01665c 100%);">
        <div class="absolute inset-0" style="opacity:0.12;background:
            radial-gradient(circle at 25% 20%, #ffffff, transparent 42%),
            radial-gradient(circle at 80% 0%, #32e0c4, transparent 35%);"></div>
        <div class="relative max-w-6xl mx-auto px-4 py-16 md:py-20 space-y-6">
            <nav class="text-sm text-white/80 flex gap-2 items-center font-medium">
                <span class="font-semibold text-white">Spacelink Blog</span>
                <span>›</span>
                <span>{{ ucfirst($page['type'] ?? 'Post') }}</span>
                <span>›</span>
                <span class="text-white/90">{{ $page['title'] }}</span>
            </nav>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-tight drop-shadow-sm text-white">
                {{ $page['title'] }}
            </h1>
            @if(!empty($page['meta_description']))
                <p class="text-lg md:text-xl text-white max-w-4xl leading-relaxed">
                    {{ $page['meta_description'] }}
                </p>
            @endif
            <div class="flex flex-wrap items-center gap-3 text-sm text-white/85">
                <span class="px-3 py-1 rounded-full bg-white/12 border border-white/20">{{ ucfirst($page['type'] ?? 'Post') }}</span>
                <span class="px-3 py-1 rounded-full bg-white/12 border border-white/20">{{ $page['slug'] }}</span>
                <span class="px-3 py-1 rounded-full bg-white/12 border border-white/20">{{ $readMinutes }} min read</span>
                @if($publishedDate)
                    <span class="px-3 py-1 rounded-full bg-white/12 border border-white/20">{{ $publishedDate }}</span>
                @endif
            </div>
        </div>
    </section>

    <section class="bg-white">
        <div class="max-w-6xl mx-auto px-4 py-12 md:py-16 space-y-12">
            <div class="grid gap-8 lg:gap-10 lg:grid-cols-3 items-start">
                <div class="lg:col-span-2 space-y-6">
                    @if(!empty($image))
                        <img src="{{ $image }}" alt="{{ $page['alt'] ?? $page['title'] }}" class="w-full rounded-2xl shadow-xl object-cover">
                    @endif
                </div>
                <aside class="space-y-4 p-6 bg-slate-50 border border-slate-200 rounded-2xl shadow-sm">
                    <h2 class="text-xl font-bold text-slate-800">Page details</h2>
                    <ul class="text-slate-700 text-sm space-y-2">
                        <li><strong>Type:</strong> {{ $page['type'] ?? 'Page' }}</li>
                        <li><strong>Slug:</strong> {{ $page['slug'] }}</li>
                        @if(!empty($page['meta_title']))
                            <li><strong>Meta title:</strong> {{ $page['meta_title'] }}</li>
                        @endif
                        @if(!empty($page['meta_description']))
                            <li><strong>Meta description:</strong> {{ $page['meta_description'] }}</li>
                        @endif
                        <li><strong>Estimated read:</strong> {{ $readMinutes }} min</li>
                        @if($publishedDate)
                            <li><strong>Published:</strong> {{ $publishedDate }}</li>
                        @endif
                    </ul>
                </aside>
            </div>

            <article class="prose prose-lg max-w-none rich-copy md:columns-2 md:gap-10 lg:columns-2 xl:columns-3">
                {!! $page['description'] ?? '' !!}
            </article>
        </div>
    </section>
</div>
@endsection
