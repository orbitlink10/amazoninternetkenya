@extends('layouts.app')

@section('title', 'Spacelink Internet Kenya | High-Speed Satellite & Broadband')
@section('meta_description', $content['hero_subtitle'] ?? 'Reliable internet connectivity, 4G kits, and broadband for homes and businesses.')

@php
    $heroPath = $content['hero_image'] ?? null;
    $heroLocal = $heroPath ? public_path('storage/'.$heroPath) : null;
    $heroUrl = ($heroLocal && file_exists($heroLocal)) ? asset('storage/'.$heroPath) : asset('images/og-placeholder.png');
@endphp
@section('meta_image', $heroUrl)

@push('head')
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@type": "Organization",
      "name": "Spacelink Internet Kenya",
      "url": "{{ url('/') }}",
      "logo": "{{ $heroUrl }}",
      "contactPoint": [{
        "@type": "ContactPoint",
        "telephone": "{{ $content['contact_phone'] ?? '+254 741 446 150' }}",
        "contactType": "customer support",
        "areaServed": "KE"
      }]
    }
    </script>
    @if($products->count())
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@type": "ItemList",
      "itemListElement": [
        @foreach($products as $index => $product)
        {
          "@type": "ListItem",
          "position": {{ $index + 1 }},
          "url": "{{ route('products.show', $product->slug) }}",
          "name": "{{ $product->name }}",
          "image": "{{ optional($product->images->first())->url ?? $heroUrl }}",
          "offers": {
            "@type": "Offer",
            "priceCurrency": "KES",
            "price": "{{ $product->sale_price ?? $product->price }}"
          }
        }@if(!$loop->last),@endif
        @endforeach
      ]
    }
    </script>
    @endif
@endpush

@section('content')
        @php
            $btnOrangeStyle = 'background:#ff951e;color:#fff;border:none;box-shadow:0 10px 22px rgba(255,149,30,0.28);padding:12px 18px;border-radius:14px;text-decoration:none;';
            $btnBlueOutline = 'border:2px solid #1f7aff;color:#1f7aff;background:#fff;padding:12px 18px;border-radius:14px;text-decoration:none;box-shadow:0 6px 16px rgba(31,122,255,0.16);';
            $waNumber = preg_replace("/\\D+/", '', ($content['contact_whatsapp'] ?? $homeContent['contact_whatsapp'] ?? '254774849471'));
            $waLink = 'https://wa.me/'.$waNumber;
        @endphp

        <!-- Top contact strip -->
        <div class="bg-slate-900 text-slate-100 text-sm">
            <div class="max-w-6xl mx-auto px-6 py-2 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                <span class="font-semibold">Need help? {{ $content['contact_phone'] ?? '+254 741 446 150' }}</span>
                <div class="flex items-center gap-4">
                    <a href="mailto:{{ $content['contact_email'] ?? 'info@spacelinkkenya.co.ke' }}" class="hover:text-white/80">{{ $content['contact_email'] ?? 'info@spacelinkkenya.co.ke' }}</a>
                    <a href="https://wa.me/254774849471" target="_blank" rel="noreferrer" class="hover:text-white/80">WhatsApp</a>
                </div>
            </div>
        </div>

    <!-- Main nav -->
    <header class="bg-white border-b border-slate-200/80 shadow-sm">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-sm">SL</div>
                <div>
                    <p class="text-lg font-bold text-slate-900 leading-tight">Spacelink Internet</p>
                    <p class="text-xs text-slate-500">Starlink & Broadband Experts</p>
                </div>
            </div>
            <nav class="hidden md:flex items-center gap-6 text-sm font-semibold text-slate-700">
                <a href="#hero" class="hover:text-slate-900">Home</a>
                <a href="#packages" class="hover:text-slate-900">Shop</a>
                <a href="#features" class="hover:text-slate-900">Services</a>
                <a href="#contact" class="hover:text-slate-900">Contact</a>
            </nav>
            <div class="hidden md:flex items-center gap-3">
                <a href="tel:+254774849471" class="px-3 py-2 rounded-full bg-slate-900 text-white text-sm font-semibold shadow-sm">Call Sales</a>
            </div>
        </div>
    </header>

    <!-- Hero -->
    <section id="hero" class="relative overflow-hidden bg-gradient-to-br from-slate-50 via-white to-cyan-50 border-b border-slate-200/70">
        <div class="max-w-6xl mx-auto px-6 py-14 grid lg:grid-cols-2 gap-10">
            <div class="space-y-6">
                <span class="inline-flex px-4 py-1.5 rounded-full bg-slate-900 text-white text-xs font-semibold uppercase tracking-[0.22em]">Kenya-wide installs</span>
                <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 leading-tight">{{ $content['hero_title'] ?? 'Starlink & Spacelink Internet for homes, SMEs, and remote sites' }}</h1>
                <p class="text-lg text-slate-600">{{ $content['hero_subtitle'] ?? 'Kits delivered, installed, and optimized by local engineers. Reliable connectivity with responsive support and flexible plans.' }}</p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('products.index') }}" class="btn-orange" style="{{ $btnOrangeStyle }}">{{ $content['cta_text'] ?? 'View plans' }}</a>
                    <a href="{{ $waLink }}" target="_blank" rel="noreferrer" class="btn-outline-blue" style="{{ $btnBlueOutline }}">Chat with an expert</a>
                </div>
                <div class="flex flex-wrap gap-6 text-sm text-slate-600">
                    <div><span class="font-semibold text-slate-900">2000+ </span>Installs delivered</div>
                    <div><span class="font-semibold text-slate-900">Kenya-wide </span>field teams</div>
                    <div><span class="font-semibold text-slate-900">24/7 </span>support channel</div>
                </div>
            </div>
            <div class="relative">
                <div class="absolute -inset-6 bg-gradient-to-br from-orange-100 via-white to-cyan-100 blur-3xl"></div>
                <div class="relative bg-white border border-slate-200 rounded-3xl shadow-2xl overflow-hidden">
                    <div class="h-full w-full flex items-center justify-center py-12 px-6">
                        @php
                            $heroPath = $content['hero_image'] ?? null;
                            $heroLocal = $heroPath ? public_path('storage/'.$heroPath) : null;
                            $heroUrl = ($heroLocal && file_exists($heroLocal)) ? asset('storage/'.$heroPath) : null;
                        @endphp
                        @if($heroUrl)
                            <img src="{{ $heroUrl }}" alt="Hero image" class="w-full h-64 object-cover rounded-2xl">
                        @else
                            <div class="w-full h-64 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400">Hero image placeholder</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

        <!-- Testimonials / installs -->
        @php
            $testimonials = $content['testimonials'] ?? [];
            $testimonials = collect($testimonials)->filter(function ($t) {
                return !empty(trim($t['title'] ?? '')) || !empty(trim($t['copy'] ?? ''));
            })->values();
        @endphp
        @if($testimonials->count())
            <section class="py-14 bg-white border-t border-b border-slate-200">
                <div class="max-w-6xl mx-auto px-6">
                    <p class="text-sm uppercase tracking-[0.35em] text-orange-500">Testimonials</p>
                    <h2 class="mt-3 text-3xl font-bold text-slate-900">Where We’ve Delivered Connectivity: Trusted by Organizations Nationwide.</h2>
                    <div class="mt-6 grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                        @foreach($testimonials as $item)
                            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                                <h3 class="font-semibold text-slate-900 mb-2">{{ $item['title'] }}</h3>
                                @php
                                    $img = $item['image'] ?? null;
                                    if ($img && !Str::startsWith($img, ['http://','https://'])) {
                                        $img = asset('storage/'.$img);
                                    }
                                @endphp
                                @if(!empty($img))
                                    <div class="h-28 w-full mb-3 rounded-xl overflow-hidden bg-slate-100 border border-slate-200">
                                        <img src="{{ $img }}" alt="{{ $item['title'] ?? 'testimonial' }}" class="h-full w-full object-cover">
                                    </div>
                                @endif
                                <div class="rich-copy text-slate-700 mt-2">
                                    {!! $item['copy'] !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Packages / shop preview -->
        <section id="packages" class="py-14 bg-white border-b border-slate-200">
            <div class="max-w-6xl mx-auto px-6">
                <div class="flex items-center justify-between gap-4 flex-wrap">
                    <div>
                        <p class="text-sm uppercase tracking-[0.35em] text-orange-500">Shop</p>
                        <h2 class="mt-3 text-3xl font-bold text-slate-900">Popular Starlink & Spacelink offers</h2>
                </div>
                <a class="inline-flex items-center gap-2 text-cyan-700 hover:text-cyan-900 font-semibold" href="{{ route('products.index') }}">View all →</a>
            </div>
            <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse($products as $product)
                    @php
                        $img = $product->images->first();
                        $imgUrl = $img ? $img->url : null;
                        $price = $product->sale_price ?? $product->price;
                    @endphp
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-md hover:shadow-lg transition-shadow">
                        <div class="h-32 mb-4 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 text-sm overflow-hidden">
                            @if($imgUrl)
                                <img src="{{ $imgUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                Image
                            @endif
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">{{ $product->name }}</h3>
                        <p class="text-sm text-cyan-700 font-semibold mt-1">
                            @if($product->sale_price)
                                From KES {{ number_format($product->sale_price) }} <span class="text-slate-400 line-through">KES {{ number_format($product->price) }}</span>
                            @else
                                From KES {{ number_format($price) }}
                            @endif
                        </p>
                        @php
                            $desc = $product->meta_description ?? null;
                            if (!$desc) {
                                $desc = Str::limit(strip_tags($product->description), 90);
                            }
                        @endphp
                        <p class="text-sm text-slate-600 mt-2">{{ $desc }}</p>
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('products.show', $product->slug) }}" class="flex-1 btn-orange text-sm font-semibold justify-center" style="{{ $btnOrangeStyle }}">View</a>
                            <a href="{{ $waLink }}" class="flex-1 btn-outline-blue text-sm font-semibold justify-center" style="{{ $btnBlueOutline }}">Call</a>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-600">No products available yet.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Services/features -->
    <section id="features" class="py-14 bg-[#f5f7fb]">
        <div class="max-w-6xl mx-auto px-6">
            <p class="text-sm uppercase tracking-[0.35em] text-orange-500">Services</p>
            <h2 class="mt-3 text-3xl font-bold text-slate-900">Internet that fits every scenario</h2>
            <div class="mt-6 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                 @php
                     $services = $content['services'] ?? [];
                     if (empty($services)) {
                         $services = [
                             ['title' => 'Home & SME', 'copy' => 'Starlink, 4G, and broadband with smart Wi‑Fi design.'],
                             ['title' => 'Enterprise', 'copy' => 'Dedicated fibre, SD‑WAN, QoS, and proactive monitoring.'],
                             ['title' => 'Events & Field', 'copy' => 'Rapid deployment internet for pop-ups, sites, and broadcasts.'],
                             ['title' => 'Support', 'copy' => '24/7 NOC, remote diagnostics, and on-site engineers.'],
                             ['title' => 'Coverage', 'copy' => 'Nairobi, Kiambu, Kajiado, Mombasa, Kisumu, Eldoret and more.'],
                             ['title' => 'Billing Flex', 'copy' => 'Monthly, project-based, or short-term event packages.'],
                         ];
                     }
                    $services = collect($services)->filter(function ($s) {
                        return !empty(trim($s['title'] ?? '')) || !empty(trim($s['copy'] ?? ''));
                    })->values();
                @endphp
                @foreach($services as $service)
                    <div class="rounded-2xl bg-white border border-slate-200 p-5 shadow-sm">
                        <h3 class="font-semibold text-slate-900">{{ $service['title'] }}</h3>
                        <div class="rich-copy text-slate-700 mt-2">
                            {!! $service['copy'] !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Contact CTA -->
    <section id="contact" class="py-14 bg-white border-t border-slate-200">
        <div class="max-w-4xl mx-auto px-6 text-center space-y-4">
            <p class="text-sm uppercase tracking-[0.35em] text-orange-500">Ready to connect?</p>
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">Talk to our team today</h2>
            <p class="text-slate-600 text-lg">Share your location and needs; we’ll recommend the best kit and schedule installation.</p>
            @php
                $btnOrangeStyle = $btnOrangeStyle ?? 'background:#ff951e;color:#fff;border:none;box-shadow:0 10px 22px rgba(255,149,30,0.28);padding:12px 18px;border-radius:14px;text-decoration:none;';
                $btnBlueOutline = $btnBlueOutline ?? 'border:2px solid #1f7aff;color:#1f7aff;background:#fff;padding:12px 18px;border-radius:14px;text-decoration:none;box-shadow:0 6px 16px rgba(31,122,255,0.16);';
                $contactPhone = $content['contact_phone'] ?? ($homeContent['contact_phone'] ?? '+254 774 849 471');
                $contactEmail = $content['contact_email'] ?? ($homeContent['contact_email'] ?? 'info@spacelinkkenya.co.ke');
                $waNumber = preg_replace('/\\D+/', '', ($content['contact_whatsapp'] ?? $homeContent['contact_whatsapp'] ?? '254774849471'));
                $waLink = 'https://wa.me/'.$waNumber;
            @endphp
            <div class="pt-4 flex flex-col md:flex-row items-center justify-center gap-3">
                <a class="btn-orange" style="{{ $btnOrangeStyle }}" href="{{ $waLink }}" target="_blank" rel="noreferrer">WhatsApp Sales</a>
                <a class="btn-outline-blue" style="{{ $btnBlueOutline }}" href="mailto:{{ $contactEmail }}">Email us</a>
                <a class="btn-outline-blue" style="{{ $btnBlueOutline }}" href="tel:{{ $contactPhone }}">Call {{ $contactPhone }}</a>
            </div>
        </div>
    </section>

    <!-- In-depth content block (placed after contact) -->
    <section id="guide" class="py-14 bg-gradient-to-br from-white via-slate-50 to-orange-50 border-b border-slate-200/70">
        <div class="max-w-6xl mx-auto px-6">
            <div class="bg-white/90 backdrop-blur rounded-3xl shadow-xl border border-slate-200/70 overflow-hidden">
                <div class="h-1.5 bg-gradient-to-r from-orange-400 via-cyan-400 to-blue-500"></div>
                <div class="p-8 md:p-10 lg:p-12 space-y-6">
                    <div class="space-y-3">
                        <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight">Starlink Kenya: A Comprehensive Guide to Satellite Internet Connectivity</h2>
                        <p class="text-lg text-slate-600 leading-relaxed">Explore how low‑earth orbit satellites are transforming access across Kenya. Understand speeds, installation, pricing, benefits, and how Starlink compares to fibre, 4G/5G, and microwave links.</p>
                    </div>
                    <div class="space-y-4 text-slate-700 leading-relaxed">
                        @if(!empty($content['long_content']))
                            {!! $content['long_content'] !!}
                        @else
                            <p>While cities like Nairobi and Mombasa grow fast, millions in rural and peri‑urban regions remain underserved. Terrain, long fibre hauls, and sparse populations make legacy broadband costly. Starlink bypasses those hurdles by bringing <strong>fast, reliable internet directly to homes and businesses nationwide</strong>.</p>
                            <h3 class="text-xl font-bold text-slate-900">What you’ll learn in this guide</h3>
                            <ul class="list-disc pl-5 space-y-2">
                                <li>How Starlink works and why latency is much lower than traditional satellite.</li>
                                <li>Typical Kenyan install timelines, roof/ground mounting options, and power needs.</li>
                                <li>Realistic speeds, fair‑use considerations, and how weather impacts performance.</li>
                                <li>Costs: hardware, monthly plans, and when to bundle with SD‑WAN or 4G backup.</li>
                                <li>Best fits: remote homes, SMEs, construction sites, agribusiness, schools, and events.</li>
                            </ul>
                            <p class="text-slate-700">Our engineering teams handle delivery, mounting, alignment, Wi‑Fi design, and proactive monitoring. We also advise when to pair Starlink with fibre or LTE for higher uptime.</p>
                        @endif
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 text-sm">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs uppercase tracking-[0.25em] text-orange-500">Coverage</p>
                            <p class="mt-2 font-semibold text-slate-900">Nationwide installs</p>
                            <p class="text-slate-600 mt-1">Urban, peri‑urban, and hard‑to‑reach rural locations.</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs uppercase tracking-[0.25em] text-orange-500">Uptime</p>
                            <p class="mt-2 font-semibold text-slate-900">Dual‑path options</p>
                            <p class="text-slate-600 mt-1">Starlink + fibre/4G failover, SD‑WAN, QoS, and monitoring.</p>
                        </div>
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-xs uppercase tracking-[0.25em] text-orange-500">Support</p>
                            <p class="mt-2 font-semibold text-slate-900">Local field teams</p>
                            <p class="text-slate-600 mt-1">Certified installers, on‑site surveys, and 24/7 help desk.</p>
                        </div>
                    </div>
                    <div class="pt-4 flex flex-wrap gap-3">
                        <a href="#contact" class="btn-orange" style="{{ $btnOrangeStyle }}">Talk to our engineers</a>
                        <a href="{{ route('products.index') }}" class="btn-outline-blue" style="{{ $btnBlueOutline }}">View plans</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
