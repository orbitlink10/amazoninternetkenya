@extends('admin.layout')

@section('title', 'Homepage Content')

@section('content')
<div class="bg-[#eef2fb] px-4 md:px-8 py-6">
    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-50 border border-green-100 text-green-700 px-4 py-3 text-sm shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="flex items-center justify-between gap-4 flex-wrap">
        <div>
            <span class="inline-flex px-4 py-1.5 rounded-full bg-slate-200 text-xs font-semibold text-slate-700 uppercase tracking-wide">Content</span>
            <h1 class="mt-3 text-4xl font-extrabold text-slate-900">Homepage Content</h1>
            <p class="text-slate-600 text-lg">Edit hero text, highlights, and call-to-actions.</p>
        </div>
        <a href="#content-form" class="px-5 py-3 rounded-full bg-blue-600 text-white font-semibold shadow-lg shadow-blue-200 flex items-center gap-2">✏️ Edit Sections</a>
    </div>

    <form id="content-form" method="POST" action="{{ route('admin.homepage.save') }}" enctype="multipart/form-data" class="mt-6 rounded-2xl border border-slate-200 bg-white shadow-sm">
        @csrf
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <p class="text-lg font-semibold text-slate-900">Sections</p>
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Live form</span>
        </div>
        <div class="px-6 py-8 space-y-8">
            <div class="grid gap-6 lg:grid-cols-2">
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-700" for="hero_image">Hero image</label>
                    @php
                        $heroPath = $content['hero_image'] ?? null;
                        $heroLocal = $heroPath ? public_path('storage/'.$heroPath) : null;
                        $heroUrl = ($heroLocal && file_exists($heroLocal)) ? asset('storage/'.$heroPath) : null;
                    @endphp
                    @if($heroUrl)
                        <div class="w-full h-40 rounded-xl border border-slate-200 overflow-hidden bg-slate-50">
                            <img src="{{ $heroUrl }}" alt="Hero image" class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-full h-40 rounded-xl border border-dashed border-slate-200 bg-slate-50 flex items-center justify-center text-slate-400 text-sm">
                            No hero image uploaded yet
                        </div>
                    @endif
                    <input id="hero_image" name="hero_image" type="file" accept="image/*" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 focus:border-blue-400 focus:ring focus:ring-blue-100">
                    <p class="text-xs text-slate-500">Upload a large, high-quality JPG/PNG (max 2MB).</p>
                    @error('hero_image')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-700" for="hero_title">Hero title</label>
                    <input id="hero_title" name="hero_title" type="text" value="{{ old('hero_title', $content['hero_title']) }}" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 focus:border-blue-400 focus:ring focus:ring-blue-100" required maxlength="120">
                    @error('hero_title')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-700" for="hero_subtitle">Hero subtitle</label>
                    <textarea id="hero_subtitle" name="hero_subtitle" rows="2" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 focus:border-blue-400 focus:ring focus:ring-blue-100" required maxlength="240">{{ old('hero_subtitle', $content['hero_subtitle']) }}</textarea>
                    @error('hero_subtitle')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-700" for="highlight_one">Highlight 1</label>
                    <textarea id="highlight_one" name="highlight_one" rows="2" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 focus:border-blue-400 focus:ring focus:ring-blue-100" required maxlength="160">{{ old('highlight_one', $content['highlight_one']) }}</textarea>
                    @error('highlight_one')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-700" for="highlight_two">Highlight 2</label>
                    <textarea id="highlight_two" name="highlight_two" rows="2" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 focus:border-blue-400 focus:ring focus:ring-blue-100" required maxlength="160">{{ old('highlight_two', $content['highlight_two']) }}</textarea>
                    @error('highlight_two')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-700" for="highlight_three">Highlight 3</label>
                    <textarea id="highlight_three" name="highlight_three" rows="2" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 focus:border-blue-400 focus:ring focus:ring-blue-100" required maxlength="160">{{ old('highlight_three', $content['highlight_three']) }}</textarea>
                    @error('highlight_three')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-700" for="cta_text">CTA text</label>
                    <input id="cta_text" name="cta_text" type="text" value="{{ old('cta_text', $content['cta_text']) }}" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 focus:border-blue-400 focus:ring focus:ring-blue-100" required maxlength="60">
                    @error('cta_text')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-700" for="cta_link">CTA link</label>
                    <input id="cta_link" name="cta_link" type="text" value="{{ old('cta_link', $content['cta_link']) }}" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 focus:border-blue-400 focus:ring focus:ring-blue-100" required maxlength="120">
                    @error('cta_link')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="space-y-3">
                <label class="block text-sm font-semibold text-slate-700" for="testimonial_blurb">Testimonial blurb</label>
                <textarea id="testimonial_blurb" name="testimonial_blurb" rows="3" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 focus:border-blue-400 focus:ring focus:ring-blue-100" required maxlength="220">{{ old('testimonial_blurb', $content['testimonial_blurb']) }}</textarea>
                @error('testimonial_blurb')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-700" for="contact_phone">Contact phone</label>
                    <input id="contact_phone" name="contact_phone" type="text" value="{{ old('contact_phone', $content['contact_phone'] ?? '+254 741 446 150') }}" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 focus:border-blue-400 focus:ring focus:ring-blue-100" required maxlength="40">
                    @error('contact_phone')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-700" for="contact_email">Contact email</label>
                    <input id="contact_email" name="contact_email" type="email" value="{{ old('contact_email', $content['contact_email'] ?? 'info@spacelinkkenya.co.ke') }}" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 focus:border-blue-400 focus:ring focus:ring-blue-100" required maxlength="120">
                    @error('contact_email')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
                <div class="space-y-3">
                    <label class="block text-sm font-semibold text-slate-700" for="contact_whatsapp">WhatsApp number</label>
                    <input id="contact_whatsapp" name="contact_whatsapp" type="text" value="{{ old('contact_whatsapp', $content['contact_whatsapp'] ?? '254774849471') }}" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 focus:border-blue-400 focus:ring focus:ring-blue-100" required maxlength="40" placeholder="2547XXXXXXXX">
                    <p class="text-xs text-slate-500">Digits only (international format) for WhatsApp buttons.</p>
                    @error('contact_whatsapp')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="space-y-3">
                <label class="block text-sm font-semibold text-slate-700" for="long_content">Home page content (rich text)</label>
                <textarea id="long_content" name="long_content" rows="10" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-slate-900 focus:border-blue-400 focus:ring focus:ring-blue-100">{{ old('long_content', $content['long_content']) }}</textarea>
                @error('long_content')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.35em] text-orange-500">Services grid</p>
                        <h3 class="text-xl font-bold text-slate-900">Internet that fits every scenario</h3>
                        <p class="text-sm text-slate-600">Edit the cards shown in the Services section on the homepage.</p>
                    </div>
                </div>

                @php
                    $services = old('services', $content['services'] ?? []);
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
                    // pad to 6 slots
                    while (count($services) < 6) {
                        $services[] = ['title' => '', 'copy' => ''];
                    }
                @endphp

                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($services as $i => $service)
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 space-y-3">
                            <div class="flex items-center justify-between">
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Card {{ $i + 1 }}</p>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-semibold text-slate-700">Title</label>
                                <input type="text" name="services[{{ $i }}][title]" value="{{ $service['title'] ?? '' }}" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-400 focus:ring focus:ring-blue-100">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-semibold text-slate-700">Copy</label>
                                <textarea name="services[{{ $i }}][copy]" rows="4" class="service-copy w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-400 focus:ring focus:ring-blue-100">{{ $service['copy'] ?? '' }}</textarea>
                            </div>
                        </div>
                    @endforeach
                </div>
                <p class="text-xs text-slate-500">You can edit up to 12 cards; leave blanks to keep defaults.</p>
                @error('services.*.title')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
                @error('services.*.copy')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.35em] text-orange-500">Testimonials</p>
                        <h3 class="text-xl font-bold text-slate-900">Where We’ve Delivered Connectivity</h3>
                        <p class="text-sm text-slate-600">List installs/projects that appear above the Shop section.</p>
                    </div>
                </div>

                @php
                    $testimonials = old('testimonials', $content['testimonials'] ?? []);
                    if (empty($testimonials)) {
                        $testimonials = [
                            ['title' => 'Nationwide ISP Network', 'copy' => 'Core/edge upgrades across Nairobi, Mombasa, Kisumu, Eldoret with 99.95% uptime targets.', 'image' => null],
                            ['title' => 'Healthcare Campus Wi‑Fi', 'copy' => 'Secure staff/guest SSIDs, SD‑WAN failover, and proactive monitoring for medical campuses.', 'image' => null],
                            ['title' => 'Remote Sites & Camps', 'copy' => 'Starlink + 4G hybrid links with portable power for construction and exploration sites.', 'image' => null],
                            ['title' => 'Events & Broadcasts', 'copy' => 'High-bandwidth pop-up internet for live events, TV uplinks, and exhibitions.', 'image' => null],
                        ];
                    }
                    while (count($testimonials) < 8) {
                        $testimonials[] = ['title' => '', 'copy' => '', 'image' => null];
                    }
                @endphp

                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    @foreach($testimonials as $i => $item)
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 space-y-3">
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Card {{ $i + 1 }}</p>
                            <div class="space-y-2">
                                <label class="text-xs font-semibold text-slate-700">Title</label>
                                <input type="text" name="testimonials[{{ $i }}][title]" value="{{ $item['title'] ?? '' }}" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-400 focus:ring focus:ring-blue-100">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-semibold text-slate-700">Copy</label>
                                <textarea name="testimonials[{{ $i }}][copy]" rows="4" class="testimonial-copy w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-400 focus:ring focus:ring-blue-100">{{ $item['copy'] ?? '' }}</textarea>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-semibold text-slate-700">Image (optional)</label>
                                @php
                                    $img = $item['image'] ?? null;
                                    $imgUrl = null;
                                    if ($img && !Str::startsWith($img, ['http://','https://'])) {
                                        $imgUrl = asset('storage/'.$img);
                                    } elseif ($img) {
                                        $imgUrl = $img;
                                    }
                                @endphp
                                @if($imgUrl)
                                    <div class="h-24 w-full rounded-lg border border-slate-200 bg-white overflow-hidden">
                                        <img src="{{ $imgUrl }}" alt="testimonial image" class="h-full w-full object-cover">
                                    </div>
                                @endif
                                <input type="file" name="testimonials[{{ $i }}][image]" accept="image/*" class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-400 focus:ring focus:ring-blue-100">
                            </div>
                        </div>
                    @endforeach
                </div>
                <p class="text-xs text-slate-500">Use bullets, bold, and links to highlight project details. Empty rows are ignored.</p>
                @error('testimonials.*.title')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
                @error('testimonials.*.copy')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="px-5 py-3 rounded-xl bg-blue-600 text-white font-semibold shadow-lg shadow-blue-200">Save</button>
                <a href="{{ route('admin.dashboard') }}" class="px-5 py-3 rounded-xl border border-slate-300 text-slate-800 font-semibold bg-white">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
    @once
        <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
    @endonce
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.tinymce) {
                tinymce.init({
                    selector: '#long_content',
                    menubar: true,
                    plugins: 'link lists table code',
                    toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | link table | code',
                    height: 400,
                });

                tinymce.init({
                    selector: '.service-copy',
                    menubar: false,
                    plugins: 'lists link textcolor',
                    toolbar: 'undo redo | bold italic underline forecolor | bullist numlist | link',
                    height: 200,
                    branding: false,
                });

                tinymce.init({
                    selector: '.testimonial-copy',
                    menubar: false,
                    plugins: 'lists link textcolor',
                    toolbar: 'undo redo | bold italic underline forecolor | bullist numlist | link',
                    height: 180,
                    branding: false,
                });
            }
        });
    </script>
@endpush
