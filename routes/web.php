<?php

use App\Http\Controllers\AufgabeController;
use App\Http\Middleware\EnsureAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(EnsureAuth::class)->group(function () {
    Route::get('/', function () {
        return redirect()->route('token.create');
    });

    Route::get('/token/create', function (Request $request) {
        /** @var User $user */
        $user = $request->user();
        $oken = $user->createToken($request->user());
        return response()->json("Bearer " . $oken->plainTextToken);
    })->name('token.create');

    Route::get('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/api');
    })->name('logout');
});

//Route::resource('aufgabe', AufgabeController::class)->middleware('auth:sanctum');
Route::apiResource('aufgaben', AufgabeController::class)->middleware('auth:sanctum');
