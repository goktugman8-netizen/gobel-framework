<?php

namespace Gobel\Http;

use Gobel\Foundation\Application;

class Kernel
{
    /**
     * The application implementation.
     *
     * @var Application
     */
    protected $app;

    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Gobel\Http\Middleware\ShareErrorsFromSession::class,
    ];

    /**
     * Create a new HTTP kernel instance.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function handle($request)
    {
        try {
            $this->app->instance('request', $request);

            $response = $this->sendRequestThroughRouter($request);
        } catch (\Exception $e) {
            $response = $this->renderException($request, $e);
        }

        return $response;
    }

    /**
     * Send the given request through the middleware / router.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function sendRequestThroughRouter($request)
    {
        return (new \Illuminate\Pipeline\Pipeline($this->app))
            ->send($request)
            ->through($this->middleware)
            ->then($this->dispatchToRouter());
    }

    /**
     * Get the route dispatcher callback.
     *
     * @return \Closure
     */
    protected function dispatchToRouter()
    {
        return function ($request) {
            $this->app->instance('request', $request);

            return $this->app->make('router')->dispatch($request);
        };
    }


    public function renderException($request, $e)
    {
        if (env('APP_DEBUG')) {
            $whoops = new \Whoops\Run;
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            return new \Illuminate\Http\Response($whoops->handleException($e), 500);
        }

        $message = $e->getMessage();
        $file = $e->getFile();
        $line = $e->getLine();
        
        $snippet = [];
        if (file_exists($file)) {
            $lines = file($file);
            $start = max(0, $line - 10);
            $end = min(count($lines), $line + 10);
            for ($i = $start; $i < $end; $i++) {
                $snippet[$i + 1] = $lines[$i];
            }
        }

        try {
            if ($this->app->has(\Gobel\View\View::class)) {
                return view('errors.exception', [
                    'exception' => $e,
                    'message' => $message,
                    'file' => $file,
                    'line' => $line,
                    'snippet' => $snippet,
                ])->setStatusCode(500);
            }
        } catch (\Exception $viewError) {}

        return new \Illuminate\Http\Response('An error occurred: ' . $message, 500);
    }

    /**
     * Terminate the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function terminate($request, $response)
    {
        //
    }
}
