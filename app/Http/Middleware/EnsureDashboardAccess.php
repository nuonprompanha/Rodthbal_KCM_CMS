<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDashboardAccess
{
    /**
     * Restrict dashboard access to authenticated users (user_type = 'authenticated').
     * Public users are redirected to the home page.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return $next($request);
        }

        if (! $request->user()->canAccessDashboard()) {
            return redirect('/')
                ->with('status', 'You do not have access to the dashboard. Your account is for public access only.');
        }

        return $next($request);
    }
}
