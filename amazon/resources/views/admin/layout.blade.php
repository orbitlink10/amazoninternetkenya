<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f6f8fd] text-slate-800 antialiased" style="font-family: 'Manrope', system-ui, -apple-system, 'Segoe UI', sans-serif;">
    <div class="min-h-screen flex">
        @php
            $hideSidebar = $hideSidebar ?? false;
        @endphp
        @unless($hideSidebar)
            <aside class="w-72 bg-white border-r border-slate-200 shadow-sm hidden md:flex flex-col">
                <div class="px-6 py-6 border-b border-slate-200">
                    <a href="{{ url('/') }}" class="text-2xl font-extrabold text-slate-900 hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-200 rounded">
                        Spacelink Kenya
                    </a>
                </div>
                <div class="px-6 py-4 text-xs uppercase tracking-wide text-slate-500">Content Management</div>
                <nav class="flex-1 px-3 space-y-1 text-sm">
                    @php
                        $links = [
                            ['label' => 'Dashboard', 'icon' => '🧭', 'href' => route('admin.dashboard')],
                            ['label' => 'Categories', 'icon' => '📂', 'href' => route('admin.categories')],
                            ['label' => 'Sub Categories', 'icon' => '🏷️', 'href' => '#'],
                            ['label' => 'Products', 'icon' => '🛒', 'href' => route('admin.products')],
                            ['label' => 'Orders', 'icon' => '🧾', 'href' => '#'],
                            ['label' => 'Invoices', 'icon' => '📄', 'href' => '#'],
                            ['label' => 'Requests', 'icon' => '🔔', 'href' => '#'],
                            ['label' => 'Designs', 'icon' => '🧩', 'href' => '#'],
                        ];
                    @endphp
                    @foreach($links as $link)
                        <a href="{{ $link['href'] ?? '#' }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-50 {{ (request()->url() === ($link['href'] ?? '')) ? 'bg-blue-600 text-white hover:bg-blue-600 shadow-sm' : 'text-slate-700' }}">
                            <span class="text-lg">{{ $link['icon'] }}</span>
                            <span class="font-semibold">{{ $link['label'] }}</span>
                        </a>
                    @endforeach
                </nav>
                <div class="px-6 pt-6 pb-3 text-xs uppercase tracking-wide text-slate-500 border-t border-slate-200">Admin Panel</div>
                <nav class="px-3 pb-4 space-y-1 text-sm">
                    @php
                        $adminLinks = [
                            ['label' => 'Users', 'icon' => '👥', 'href' => route('admin.users')],
                            ['label' => 'Homepage Content', 'icon' => '🧾', 'href' => route('admin.homepage')],
                            ['label' => 'Sliders', 'icon' => '🖼️', 'href' => route('admin.sliders')],
                            ['label' => 'Pages', 'icon' => '✏️', 'href' => route('admin.pages')],
                            ['label' => 'Services', 'icon' => '🛠️', 'href' => route('admin.services')],
                        ];
                    @endphp
                    @foreach($adminLinks as $link)
                        @php
                            $isActive = request()->url() === ($link['href'] ?? '');
                        @endphp
                        <a href="{{ $link['href'] ?? '#' }}" class="flex items-center gap-3 px-3 py-2 rounded-lg {{ $isActive ? 'bg-blue-600 text-white hover:bg-blue-600 shadow-sm' : 'text-slate-700 hover:bg-slate-50' }}">
                            <span class="text-lg">{{ $link['icon'] }}</span>
                            <span class="font-semibold">{{ $link['label'] }}</span>
                        </a>
                    @endforeach
                </nav>
                <div class="px-4 py-4 border-t border-slate-200 text-sm">
                    <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="w-full px-3 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold">Logout</button>
                    </form>
                </div>
            </aside>
        @endunless

        <main class="flex-1 min-w-0">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>
