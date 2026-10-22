<?php

use App\Http\Controllers\SitemapController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

Route::get('/login', function (): RedirectResponse {
    return redirect(route('filament.admin.auth.login'));
})->name('login');
