<?php

namespace App\Providers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share homepage content (contact info, services, testimonials) globally for layouts/footer
        View::composer('*', function ($view) {
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
                'services' => [],
                'testimonials' => [],
            ];

            $stored = [];
            if (Storage::disk('local')->exists('homepage.json')) {
                $stored = json_decode(Storage::disk('local')->get('homepage.json'), true) ?? [];
            }

            $content = array_merge($defaults, $stored);
            // normalize whatsapp digits
            $content['contact_whatsapp'] = preg_replace('/\D+/', '', $content['contact_whatsapp'] ?? '254774849471');

            $view->with('homeContent', $content);
        });
    }
}
