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
     * Create a new HTTP kernel instance.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming HTTP request.
     *
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request)
    {
        try {
            // Here, we would pass the request through the middleware stack
            // and then pass it to the router to dispatch to the appropriate route.
            $response = $this->sendRequestThroughRouter($request);
        } catch (\Exception $e) {
            $response = $this->renderException($request, $e);
        }

        return $response;
    }

    /**
     * Send the given request through the middleware / router.
     *
     * @param Request $request
     * @return Response
     */
    protected function sendRequestThroughRouter(Request $request)
    {
        $this->app->instance('request', $request);

        // We delegate to the router to dispatch the request.
        // The router will be implemented in the next steps.
        // For now, if there is no router bound, we return a simple 404.
        
        if ($this->app->has('router')) {
            return $this->app->make('router')->dispatch($request);
        }

        return new Response('Gobel: Router not configured.', 500);
    }

    /**
     * Render the exception to a response.
     *
     * @param Request $request
     * @param \Exception|\Throwable $e
     * @return Response
     */
    public function renderException(Request $request, $e)
    {
        $message = $e->getMessage();
        $file = $e->getFile();
        $line = $e->getLine();
        
        // Get code snippet
        $snippet = $this->getFileSnippet($file, $line);

        try {
            if ($this->app->has(\Gobel\View\View::class)) {
                $response = view('errors.exception', [
                    'exception' => $e,
                    'message' => $message,
                    'file' => $file,
                    'line' => $line,
                    'snippet' => $snippet
                ]);

                return $response->setStatusCode(500);
            }
        } catch (\Exception $viewError) {
            // Fallback to basic error if view engine fails
        }

        $content = "<h1>An Error Occurred</h1>";
        $content .= "<p><strong>Message:</strong> " . $message . "</p>";
        $content .= "<p><strong>File:</strong> " . $file . " on line " . $line . "</p>";
        $content .= "<pre>" . $e->getTraceAsString() . "</pre>";
        
        return new Response($content, 500);
    }

    /**
     * Get a snippet of code from a file.
     *
     * @param string $file
     * @param int $line
     * @param int $padding
     * @return array
     */
    protected function getFileSnippet($file, $line, $padding = 10)
    {
        if (!file_exists($file)) return [];

        $lines = file($file);
        $start = max(0, $line - $padding - 1);
        $length = $padding * 2 + 1;

        $snippet = array_slice($lines, $start, $length, true);
        
        // Normalize keys to 1-based line numbers
        $normalizedSnippet = [];
        foreach ($snippet as $i => $content) {
            $normalizedSnippet[$i + 1] = rtrim($content);
        }

        return $normalizedSnippet;
    }

    /**
     * Call the terminate method on any terminable middleware.
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function terminate(Request $request, Response $response)
    {
        // ... execute middleware terminate logic
    }
}
