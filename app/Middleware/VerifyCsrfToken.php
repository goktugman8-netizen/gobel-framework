<?php

namespace App\Middleware;

use Gobel\Http\Request;
use Gobel\Http\Response;

class VerifyCsrfToken
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
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            $token = $request->input('_token');

            if (!$token || $token !== session('_token')) {
                throw new \Exception('CSRF token mismatch.');
            }
        }

        return $next($request);
    }
}
