<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Spacelink Internet Kenya - Reliable internet connectivity, 4G kits, and broadband for homes and businesses.')">
    <title>@yield('title', 'Spacelink Internet')</title>
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Open Graph / Twitter --}}
    @php
        $ogTitle = trim($__env->yieldContent('title', 'Spacelink Internet'));
        $ogDesc = trim($__env->yieldContent('meta_description', 'Spacelink Internet Kenya - Reliable internet connectivity, 4G kits, and broadband for homes and businesses.'));
        $ogImage = trim($__env->yieldContent('meta_image', asset('images/og-placeholder.png')));
    @endphp
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $ogTitle }}">
    <meta property="og:description" content="{{ $ogDesc }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $ogTitle }}">
    <meta name="twitter:description" content="{{ $ogDesc }}">
    <meta name="twitter:image" content="{{ $ogImage }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    @stack('head')
</head>
<body class="bg-[#f5f7fb] text-slate-800 antialiased theme-body" style="font-family: 'Manrope', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
    <div class="min-h-screen flex flex-col">
        @yield('content')
        <footer class="mt-auto bg-white border-t border-slate-200">
            <div class="max-w-6xl mx-auto px-6 py-10 grid gap-6 md:grid-cols-3 items-start">
                <div>
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-orange-400 to-cyan-400 flex items-center justify-center font-bold text-white shadow-sm">S</div>
                        <div>
                            <p class="text-lg font-semibold text-slate-900">Spacelink Internet</p>
                            <p class="text-sm text-slate-500">Connecting homes & businesses</p>
                        </div>
                    </div>
                    <p class="mt-4 text-sm text-slate-600 max-w-md">Built for reliability across Kenya with rapid deployment and human support.</p>
                </div>
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-slate-500">Contact</p>
                    @php
                        $contactPhone = $homeContent['contact_phone'] ?? '+254 774 849 471';
                        $contactEmail = $homeContent['contact_email'] ?? 'info@spacelinkkenya.co.ke';
                        $waNumber = $homeContent['contact_whatsapp'] ?? '254774849471';
                        $waLink = 'https://wa.me/'.$waNumber;
                    @endphp
                    <p class="mt-3 text-sm">Phone: <a class="text-cyan-700 hover:text-cyan-900 font-semibold" href="tel:{{ $contactPhone }}">{{ $contactPhone }}</a></p>
                    <p class="text-sm">Email: <a class="text-cyan-700 hover:text-cyan-900 font-semibold" href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a></p>
                    <p class="text-sm">WhatsApp: <a class="text-cyan-700 hover:text-cyan-900 font-semibold" href="{{ $waLink }}" target="_blank" rel="noreferrer">Chat now</a></p>
                </div>
                <div>
                    <p class="text-sm font-semibold uppercase tracking-wide text-slate-500">Visit</p>
                    <p class="mt-3 text-sm text-slate-700">Spacelink Business Center, 3rd Floor</p>
                    <p class="text-sm text-slate-700">Kilimani, Nairobi</p>
                    <p class="text-sm text-slate-700">Langata, Nairobi</p>
                </div>
            </div>
            <div class="border-t border-slate-200 py-4 text-center text-xs text-slate-500">© {{ date('Y') }} Spacelink Internet. All rights reserved.</div>
        </footer>
    </div>
</body>
</html>
