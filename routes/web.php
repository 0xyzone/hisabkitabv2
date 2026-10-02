<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/kitab');
});

Route::get('/manifest.webmanifest', function () {
    return response(file_get_contents(public_path('manifest.webmanifest')), 200, [
        'Content-Type' => 'application/manifest+json',
        'Cache-Control' => 'no-cache, private',
    ]);
});

Route::get('/sw.js', function () {
    return response(file_get_contents(public_path('sw.js')), 200, [
        'Content-Type' => 'application/javascript',
        'Cache-Control' => 'no-cache, private',
    ]);
});
