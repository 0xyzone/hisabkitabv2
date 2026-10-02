<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/kitab');
});

$manifestCallback = function () {
    return response()->json([
        'id' => '/kitab',
        'name' => 'HisabKitab',
        'short_name' => 'HisabKitab',
        'description' => 'Vendor Returns, Payouts, and Payment Tracking System',
        'start_url' => '/kitab',
        'scope' => '/',
        'display' => 'standalone',
        'orientation' => 'any',
        'background_color' => '#18181b',
        'theme_color' => '#f59e0b',
        'categories' => ['business', 'finance', 'productivity'],
        'icons' => [
            [
                'src' => '/icons/icon-192x192.png',
                'sizes' => '192x192',
                'type' => 'image/png',
                'purpose' => 'any',
            ],
            [
                'src' => '/icons/icon-512x512.png',
                'sizes' => '512x512',
                'type' => 'image/png',
                'purpose' => 'any',
            ],
            [
                'src' => '/icons/icon-512x512-maskable.png',
                'sizes' => '512x512',
                'type' => 'image/png',
                'purpose' => 'maskable',
            ],
            [
                'src' => '/icons/icon.svg',
                'sizes' => 'any',
                'type' => 'image/svg+xml',
                'purpose' => 'any',
            ],
        ],
    ], 200, [
        'Content-Type' => 'application/manifest+json',
        'Cache-Control' => 'no-cache, private',
    ]);
};

Route::get('/manifest.webmanifest', $manifestCallback);
Route::get('/manifest.json', $manifestCallback);

Route::get('/sw.js', function () {
    return response(file_get_contents(public_path('sw.js')), 200, [
        'Content-Type' => 'application/javascript',
        'Cache-Control' => 'no-cache, private',
    ]);
});
