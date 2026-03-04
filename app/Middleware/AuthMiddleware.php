<?php

namespace App\Middleware;

use Gobel\Http\Request;
use Gobel\Http\Response;
use Gobel\Http\RedirectResponse;

class AuthMiddleware
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
        if (!auth()->check()) {
            return redirect('/login')->with('error', 'Lütfen önce giriş yapın.');
        }

        return $next($request);
    }
}
