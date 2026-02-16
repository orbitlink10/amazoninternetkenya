<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

Route::get('/', function () {
    $defaults = [
        'hero_title' => 'Spacelink Internet Kenya',
        'hero_subtitle' => 'Reliable internet connectivity, 4G kits, and broadband for homes and businesses.',
        'cta_text' => 'Get Connected',
        'cta_link' => '#contact',
        'highlight_one' => 'Nationwide coverage with rapid deployment',
        'highlight_two' => 'Human support that actually answers',
        'highlight_three' => 'Flexible plans for homes and SMEs',
        'testimonial_blurb' => 'The install was same-day and the speeds stayed fast.',
        'hero_image' => null,
        'long_content' => null,
        'contact_phone' => '+254 741 446 150',
        'contact_email' => 'info@spacelinkkenya.co.ke',
        'contact_whatsapp' => '254774849471',
        'services' => [
            ['title' => 'Home & SME', 'copy' => 'Starlink, 4G, and broadband with smart Wi‑Fi design.'],
            ['title' => 'Enterprise', 'copy' => 'Dedicated fibre, SD‑WAN, QoS, and proactive monitoring.'],
            ['title' => 'Events & Field', 'copy' => 'Rapid deployment internet for pop-ups, sites, and broadcasts.'],
            ['title' => 'Support', 'copy' => '24/7 NOC, remote diagnostics, and on-site engineers.'],
            ['title' => 'Coverage', 'copy' => 'Nairobi, Kiambu, Kajiado, Mombasa, Kisumu, Eldoret and more.'],
            ['title' => 'Billing Flex', 'copy' => 'Monthly, project-based, or short-term event packages.'],
        ],
        'testimonials' => [
            ['title' => 'Nationwide ISP Network', 'copy' => 'Core/edge upgrades across Nairobi, Mombasa, Kisumu, and Eldoret with 99.95% uptime targets.', 'image' => null],
            ['title' => 'Healthcare Campus Wi‑Fi', 'copy' => 'Multi-building secure Wi‑Fi with guest/staff segmentation and SD‑WAN failover.', 'image' => null],
            ['title' => 'Construction & Remote Sites', 'copy' => 'Starlink + 4G hybrid links with portable power for remote build sites and camps.', 'image' => null],
            ['title' => 'Events & Broadcasts', 'copy' => 'Pop-up high-bandwidth connectivity for live events, TV uplinks, and exhibitions.', 'image' => null],
        ],
    ];

    $stored = [];
    if (Storage::disk('local')->exists('homepage.json')) {
        $stored = json_decode(Storage::disk('local')->get('homepage.json'), true) ?? [];
    }

    $content = array_merge($defaults, $stored);

    $products = \App\Models\Product::with(['images'])
        ->where('is_active', true)
        ->orderByDesc('is_featured')
        ->orderBy('created_at', 'desc')
        ->take(3)
        ->get();

    return view('home', compact('content', 'products'));
});

// Storefront
Route::middleware('cart.merge')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class, 'place'])->name('checkout.place');
    Route::get('/checkout/thank-you/{order}', [CheckoutController::class, 'thankyou'])->name('checkout.thankyou');

    // Customer orders
    Route::middleware('auth')->group(function () {
        Route::get('/account/orders', function () {
            $orders = \App\Models\Order::where('user_id', auth()->id())->latest()->paginate(10);
            return view('store.account.orders', compact('orders'));
        })->name('account.orders');

        Route::get('/account/orders/{order}', function (\App\Models\Order $order) {
            abort_if($order->user_id !== auth()->id(), 403);
            $order->load('items');
            return view('store.account.order-show', compact('order'));
        })->name('account.orders.show');
    });
});

// Payment webhook (COD stub)
Route::post('/payments/callback', [PaymentController::class, 'callback'])->name('payments.callback');

// --- Admin panel ---
Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

Route::post('/admin/login', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if ($request->email === 'admin@demo.com' && $request->password === '12345678') {
        $request->session()->put('admin_auth', true);
        $request->session()->flash('success', 'Welcome back, admin.');
        return redirect()->route('admin.dashboard');
    }

    return back()->withInput()->with('error', 'Invalid credentials.');
})->name('admin.login.submit');

Route::middleware('admin.auth')->group(function () {
    Route::get('/admin', fn () => redirect()->route('admin.dashboard'));

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/users', function () {
        return view('admin.users');
    })->name('admin.users');

    Route::get('/admin/homepage-content', function () {
        $defaults = [
            'hero_title' => 'Spacelink Internet Kenya',
            'hero_subtitle' => 'Reliable internet connectivity, 4G kits, and broadband for homes and businesses.',
            'cta_text' => 'Get Connected',
            'cta_link' => '#contact',
            'highlight_one' => 'Nationwide coverage with rapid deployment',
            'highlight_two' => 'Human support that actually answers',
            'highlight_three' => 'Flexible plans for homes and SMEs',
            'testimonial_blurb' => 'The install was same-day and the speeds stayed fast.',
            'hero_image' => null,
            'long_content' => 'Add your detailed home page content here.',
        ];

        $stored = [];
        if (Storage::disk('local')->exists('homepage.json')) {
            $stored = json_decode(Storage::disk('local')->get('homepage.json'), true) ?? [];
        }

        return view('admin.homepage', [
            'content' => array_merge($defaults, $stored),
        ]);
    })->name('admin.homepage');

    Route::post('/admin/homepage-content', function (Request $request) {
        $data = $request->validate([
            'hero_title' => ['required', 'string', 'max:120'],
            'hero_subtitle' => ['required', 'string', 'max:240'],
            'cta_text' => ['required', 'string', 'max:60'],
            'cta_link' => ['required', 'string', 'max:120'],
            'highlight_one' => ['required', 'string', 'max:160'],
            'highlight_two' => ['required', 'string', 'max:160'],
            'highlight_three' => ['required', 'string', 'max:160'],
            'testimonial_blurb' => ['required', 'string', 'max:220'],
            'hero_image' => ['nullable', 'image', 'max:2048'],
            'long_content' => ['nullable', 'string'],
            'contact_phone' => ['required', 'string', 'max:40'],
            'contact_email' => ['required', 'email', 'max:120'],
            'contact_whatsapp' => ['required', 'string', 'max:40'],
            'services' => ['nullable', 'array', 'max:6'],
            'services.*.title' => ['nullable', 'string', 'max:160'],
            'services.*.copy' => ['nullable', 'string', 'max:400'],
            'testimonials' => ['nullable', 'array', 'max:8'],
            'testimonials.*.title' => ['nullable', 'string', 'max:160'],
            'testimonials.*.copy' => ['nullable', 'string', 'max:400'],
            'testimonials.*.image' => ['nullable', 'image', 'max:2048'],
        ]);

        $existing = [];
        if (Storage::disk('local')->exists('homepage.json')) {
            $existing = json_decode(Storage::disk('local')->get('homepage.json'), true) ?? [];
        }

        if ($request->hasFile('hero_image')) {
            $path = $request->file('hero_image')->store('homepage', 'public');
            $data['hero_image'] = $path;
        } else {
            $data['hero_image'] = $existing['hero_image'] ?? null;
        }

        // Clean services: drop empty rows, fall back to defaults if none remain
        $cleanServices = [];
        if (!empty($data['services'] ?? [])) {
            foreach ($data['services'] as $row) {
                $title = trim($row['title'] ?? '');
                $copy = trim($row['copy'] ?? '');
                if ($title !== '' || $copy !== '') {
                    $cleanServices[] = [
                        'title' => $title,
                        'copy' => $copy,
                    ];
                }
            }
        }
        if (empty($cleanServices)) {
            $cleanServices = $existing['services'] ?? $defaults['services'];
        }
        $data['services'] = array_values($cleanServices);

        // Testimonials
        $cleanTestimonials = [];
        $testimonialFiles = $request->file('testimonials', []);
        if (!empty($data['testimonials'] ?? [])) {
            foreach ($data['testimonials'] as $idx => $row) {
                $title = trim($row['title'] ?? '');
                $copy = trim($row['copy'] ?? '');
                $imagePath = $existing['testimonials'][$idx]['image'] ?? null;
                if (!empty($testimonialFiles[$idx]['image'] ?? null)) {
                    $imagePath = $testimonialFiles[$idx]['image']->store('testimonials', 'public');
                }
                if ($title !== '' || $copy !== '' || $imagePath) {
                    $cleanTestimonials[] = [
                        'title' => $title,
                        'copy' => $copy,
                        'image' => $imagePath,
                    ];
                }
            }
        }
        if (empty($cleanTestimonials)) {
            $cleanTestimonials = $existing['testimonials'] ?? $defaults['testimonials'];
        }
        $data['testimonials'] = array_values($cleanTestimonials);

        // Normalize WhatsApp number to digits only for wa.me links
        $wa = preg_replace('/\D+/', '', $data['contact_whatsapp'] ?? '');
        $data['contact_whatsapp'] = $wa ?: preg_replace('/\D+/', '', $defaults['contact_whatsapp']);

        Storage::disk('local')->put('homepage.json', json_encode($data, JSON_PRETTY_PRINT));

        return redirect()->route('admin.homepage')->with('success', 'Homepage content updated.');
    })->name('admin.homepage.save');

    Route::get('/admin/sliders', function () {
        return view('admin.sliders');
    })->name('admin.sliders');

    Route::get('/admin/services', function () {
        return view('admin.services');
    })->name('admin.services');

    Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products');
    Route::get('/admin/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');

    Route::get('/admin/categories', [AdminCategoryController::class, 'index'])->name('admin.categories');
    Route::get('/admin/categories/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/admin/categories', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/admin/categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/admin/categories/{category}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/admin/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');

    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders');
    Route::get('/admin/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::post('/admin/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.status');

    Route::get('/admin/pages', function () {
        $pages = [];

        if (Storage::disk('local')->exists('pages.json')) {
            $pages = json_decode(Storage::disk('local')->get('pages.json'), true) ?? [];
        }

        // Provide one default entry if storage is empty
        if (empty($pages)) {
            $pages[] = [
                'id' => 1,
                'title' => 'Kenya Vs Tanzania Vs Uganda Internet',
                'slug' => 'kenya-vs-tanzania-vs-uganda-internet',
                'alt' => 'Kenya Vs Tanzania Vs Uganda Internet',
                'type' => 'Post',
                'description' => '<p>Compare regional connectivity options and understand coverage differences.</p>',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/6/67/Feedbin-Icon-wifi.svg',
                'meta_title' => 'Kenya Vs Tanzania Vs Uganda Internet',
                'meta_description' => 'A quick look at East African connectivity.',
            ];
            Storage::disk('local')->put('pages.json', json_encode($pages, JSON_PRETTY_PRINT));
        }

        // Ensure each page has a slug
        $pages = collect($pages)->map(function ($page) {
            if (empty($page['slug'] ?? '')) {
                $page['slug'] = Str::slug($page['title'] ?? 'page-' . ($page['id'] ?? ''));
            }
            return $page;
        })->values()->all();

        Storage::disk('local')->put('pages.json', json_encode($pages, JSON_PRETTY_PRINT));

        return view('admin.pages.index', ['posts' => $pages]);
    })->name('admin.pages');

    Route::get('/admin/pages/create', function () {
        return view('admin.pages.create');
    })->name('admin.pages.create');

    Route::post('/admin/pages', function (Request $request) {
        $data = $request->validate([
            'meta_title' => ['required', 'string', 'max:160'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:180'],
            'alt' => ['nullable', 'string', 'max:160'],
            'type' => ['required', 'in:Post,Page'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $pages = [];
        if (Storage::disk('local')->exists('pages.json')) {
            $pages = json_decode(Storage::disk('local')->get('pages.json'), true) ?? [];
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('pages', 'public');
        }

        // Generate unique slug
        $baseSlug = Str::slug($data['title']);
        $slug = $baseSlug;
        $i = 1;
        $existingSlugs = collect($pages)->pluck('slug')->filter()->all();
        while (in_array($slug, $existingSlugs)) {
            $slug = $baseSlug . '-' . $i++;
        }

        $nextId = empty($pages) ? 1 : (collect($pages)->max('id') + 1);

        $pages[] = array_merge($data, [
            'id' => $nextId,
            'slug' => $slug,
        ]);

        Storage::disk('local')->put('pages.json', json_encode($pages, JSON_PRETTY_PRINT));

        return redirect()->route('admin.pages')->with('success', 'Page saved and ready to preview.');
    })->name('admin.pages.store');

    Route::post('/admin/logout', function (Request $request) {
        $request->session()->forget('admin_auth');
        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    })->name('admin.logout');
});

// Backward compatibility: /page/{slug} should redirect to root-level slug
Route::get('/page/{slug}', function (string $slug) {
    return redirect('/' . ltrim($slug, '/'), 301);
});

Route::get('/{slug}', function (string $slug) {
    $pages = [];
    if (Storage::disk('local')->exists('pages.json')) {
        $pages = json_decode(Storage::disk('local')->get('pages.json'), true) ?? [];
    }

    $page = collect($pages)->firstWhere('slug', $slug);

    abort_if(!$page, 404);

    // Resolve image URL
    $image = $page['image'] ?? null;
    if ($image) {
        if (!Str::startsWith($image, ['http://', 'https://', '//'])) {
            $image = asset('storage/' . $image);
        }
    } else {
        $image = 'https://via.placeholder.com/800x420?text=No+image';
    }

    return view('pages.show', [
        'page' => $page,
        'image' => $image,
    ]);
})
    ->where('slug', '^(?!admin|products|cart|checkout|account|payments|storage|login|register|password|logout).+')
    ->name('pages.preview');
