<?php

use App\Http\Middleware\EnsureAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->user()->name);
    return ['token' => "Bearer ". $token->plainTextToken];
})->middleware(['auth.basic','auth.session']);

