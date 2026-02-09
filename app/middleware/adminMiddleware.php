<?php

namespace App\Http\Middleware;

class AdminMiddleware {
    public function handle($request, Closure $next) {
        return $next($request);
    }
}
