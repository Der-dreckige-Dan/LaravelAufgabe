<?php

use App\Http\Controllers\AufgabeController;
use App\Http\Middleware\AttachNotifications;
use App\Http\Middleware\EnsureAuth;
use App\Http\Middleware\EnsureOwnAufgabe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/token/create', function (Request $request) {
    /** @var User $user */
    $user = $request->user();
    $token = $user->createToken($request->user());
    return response()->json("Bearer " . $token->plainTextToken);
})->name('token.create')->middleware(EnsureAuth::class);

Route::middleware(['auth:sanctum', AttachNotifications::class])->group(function () {
    Route::get('/aufgaben/overdue', [AufgabeController::class, 'getOverdue'])->name('aufgaben.overdue');
    Route::apiResource('aufgaben', AufgabeController::class)
        ->middlewareFor(['update'], [EnsureOwnAufgabe::class]);
    Route::get('/user/{user}/aufgaben', [AufgabeController::class, 'getAufgabenFromBenutzer'])->name('user.aufgaben');
    Route::get('/projekte/{projekt}/aufgaben', [AufgabeController::class, 'getAufgabenFromProjekt'])->name('projekte.aufgaben');
});
