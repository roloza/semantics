<?php
# Socialite URLs

use App\Http\Controllers\Auth\SocialiteController;

// La redirection vers le provider
Route::get('login/{provider}', [SocialiteController::class, 'redirect'])->name('socialite.redirect');

// Le callback du provider
Route::get('login/{provider}/callback', [SocialiteController::class, 'callback'])->name('socialite.callback');

