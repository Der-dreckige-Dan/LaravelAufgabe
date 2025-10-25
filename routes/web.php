<?php

use App\Http\Controllers\AufgabeController;
use App\Http\Middleware\EnsureAuth;
use App\Http\Middleware\EnsureAuthorizedDeadline;
use App\Http\Middleware\EnsureOwnAufgabe;
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
        return redirect('/');
    })->name('logout');
});
Route::get('/aufgaben/overdue', [AufgabeController::class, 'getOverdue'])->name('aufgabe.overdue');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('aufgaben', AufgabeController::class)
    ->middlewareFor(['update'],[EnsureOwnAufgabe::class, EnsureAuthorizedDeadline::class]);
    Route::get('/user/aufgaben/{user}', [AufgabeController::class, 'getAufgabenFromBenutzer'])->name('benutzer.aufgaben');
    Route::get('/projekte/aufgaben/{projekt}', [AufgabeController::class, 'getAufgabenFromProjekt'])->name('projekte.aufgaben');
    Route::patch('/aufgaben/updateDeadline/{aufgabe}', [AufgabeController::class, 'updateDeadline'])->name('aufgaben.updateDeadline');
});

