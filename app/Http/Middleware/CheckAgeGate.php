<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAgeGate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If the cookie 'age_verified' is not set, we'll redirect back or to a specific age gate route.
        // But for a modal approach, the middleware might not block the request, it just passes 
        // a variable to the view. Actually, it's better to manage age gate in frontend JS or blade components.
        // Wait, if it's a strict gate, we can return a view directly or let JS handle it.
        // I will let it just pass, and we'll handle the modal via JS/Blade if the cookie isn't present, 
        // to avoid SEO issues and caching issues. So this middleware does nothing for now.
        return $next($request);
    }
}
