<?php

namespace App\Http\Middleware;

use App\Models\Event;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EventAccessMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $event = $request->route('event');

        if (!$event instanceof Event) {
            abort(404);
        }

        if ($request->user()->role === 'super_user') {
            return $next($request);
        }

        if (
            $request->user()->role === 'admin'
            && $event->admins()
                ->where('user_id', $request->user()->id)
                ->exists()
        ) {
            return $next($request);
        }

        abort(403);
    }
}