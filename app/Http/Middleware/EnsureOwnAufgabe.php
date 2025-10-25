<?php

namespace App\Http\Middleware;

use App\Models\Aufgabe;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOwnAufgabe {
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, Aufgabe $aufgabe): Response {
        if ($aufgabe->user()->get()->id === $request->user()->id) {
            return response()->json(null, Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
