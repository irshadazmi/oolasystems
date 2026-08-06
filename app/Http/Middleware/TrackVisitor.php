<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;
use App\Models\Visitor;
use Throwable;

class TrackVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $ip = $request->ip();
        $key = 'visitor_' . $ip;

        try {
            if (!Cache::has($key)) {

                Visitor::create([
                    'ip' => $ip,
                    'user_agent' => $request->userAgent(),
                    'page' => $request->path(),
                ]);

                Cache::put($key, true, now()->addMinutes(30)); // avoid repeat for 30 min
            }
        } catch (Throwable $e) {
            report($e);
        }

        return $next($request);
    }
}
