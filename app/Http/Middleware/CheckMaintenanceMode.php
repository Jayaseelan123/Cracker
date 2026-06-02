<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SiteSetting;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        // Don't block admin routes
        if ($request->is('admin/*') || $request->is('login')) {
            return $next($request);
        }

        $status = SiteSetting::get('website_status', 'active');
        if ($status === 'maintenance') {
            $msg = SiteSetting::get('maintenance_message', 'We are currently down for maintenance. Please check back soon.');
            return response(view('front.maintenance', compact('msg')));
        }

        return $next($request);
    }
}
