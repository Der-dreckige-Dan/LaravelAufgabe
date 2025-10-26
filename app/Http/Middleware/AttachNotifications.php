<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttachNotifications {
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response {
        $response = $next($request);
        $content = $response->getContent();
        $notifications = [];
        foreach ($request->user()->unreadNotifications as $notification) {
            $notifications[] = $notification->data['message'];
            $notification->markAsRead();
        }
        $content = sprintf("{\"notifications\":%s, \"data\":%s}", json_encode($notifications), $content);
        $response->setContent($content);
        return $response;
    }
}
