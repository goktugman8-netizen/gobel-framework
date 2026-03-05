<?php

namespace Gobel\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Gobel\Session\Session;
use Gobel\View\View;

class ShareErrorsFromSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $session = app(Session::class);
        $view = app(View::class);

        // Share errors with the view factory
        $view->share('errors', $session->get('errors', []));
        
        // Share old input with the view factory (convenience)
        $view->share('old', $session->get('_old_input', []));

        return $next($request);
    }
}
