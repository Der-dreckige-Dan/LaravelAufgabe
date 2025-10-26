<?php

use App\Http\Middleware\EnsureAuth;

Route::middleware(EnsureAuth::class)->group(function () {
    Route::get('/', function () {
        return redirect()->route('token.create');
    });
    Route::get('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});
