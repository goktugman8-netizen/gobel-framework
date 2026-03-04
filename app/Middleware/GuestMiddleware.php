<?php

namespace App\Middleware;

use Gobel\Http\Request;
use Gobel\Http\Response;
use Gobel\Http\RedirectResponse;

class GuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return Response
     */
    public function handle(Request $request, \Closure $next)
    {
        if (auth()->check()) {
            return redirect('/');
        }

        return $next($request);
    }
}
