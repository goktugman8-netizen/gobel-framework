<?php

namespace Gobel\Routing;

use Closure;
use Illuminate\Container\Container;
use Gobel\Http\Request;
use Gobel\Http\Response;

class Router
{
    /**
     * The IoC container instance.
     *
     * @var Container
     */
    protected $container;

    /**
     * The route collection.
     *
     * @var Route[]
     */
    protected $routes = [];

    /**
     * The currently dispatched route.
     *
     * @var Route|null
     */
    protected $current;

    /**
     * Create a new Router instance.
     *
     * @param Container $container
     */
    public function __construct(Container $container = null)
    {
        $this->container = $container ?: Container::getInstance();
    }

    /**
     * Register a new GET route.
     *
     * @param string $uri
     * @param mixed $action
     * @return Route
     */
    public function get($uri, $action)
    {
        return $this->addRoute(['GET', 'HEAD'], $uri, $action);
    }

    /**
     * Register a new POST route.
     *
     * @param string $uri
     * @param mixed $action
     * @return Route
     */
    public function post($uri, $action)
    {
        return $this->addRoute(['POST'], $uri, $action);
    }

    /**
     * Register a new PUT route.
     *
     * @param string $uri
     * @param mixed $action
     * @return Route
     */
    public function put($uri, $action)
    {
        return $this->addRoute(['PUT'], $uri, $action);
    }

    /**
     * Register a new PATCH route.
     *
     * @param string $uri
     * @param mixed $action
     * @return Route
     */
    public function patch($uri, $action)
    {
        return $this->addRoute(['PATCH'], $uri, $action);
    }

    /**
     * Register a new DELETE route.
     *
     * @param string $uri
     * @param mixed $action
     * @return Route
     */
    public function delete($uri, $action)
    {
        return $this->addRoute(['DELETE'], $uri, $action);
    }

    /**
     * Register a new route.
     *
     * @param array|string $methods
     * @param string $uri
     * @param mixed $action
     * @return Route
     */
    public function addRoute($methods, $uri, $action)
    {
        return $this->routes[] = new Route($methods, $uri, $action);
    }

    /**
     * Dispatch the request to the application.
     *
     * @param Request $request
     * @return Response
     */
    public function dispatch(Request $request)
    {
        return $this->runRoute($request, $this->findRoute($request));
    }

    /**
     * Find the route matching a given request.
     *
     * @param Request $request
     * @return Route
     * @throws \Exception
     */
    protected function findRoute(Request $request)
    {
        foreach ($this->routes as $route) {
            if ($route->matches($request)) {
                return $route;
            }
        }

        throw new \Exception('NotFoundHttpException: No route found for ' . $request->method() . ' ' . $request->path());
    }

    /**
     * Return the response for the given route.
     *
     * @param Request $request
     * @param Route $route
     * @return Response
     */
    protected function runRoute(Request $request, Route $route)
    {
        $this->current = $route;

        // In a full implementation, we would send the request through the route's middleware first.
        
        $action = $route->action();
        $parameters = $route->parameters();

        try {
            if ($action instanceof Closure) {
                $content = $this->container->call($action, $parameters);
            } elseif (is_array($action)) {
                // If the action is [Class, Method], let's resolve the class from the container
                if (is_string($action[0])) {
                    $instance = $this->container->make($action[0]);
                    $content = $this->container->call([$instance, $action[1]], $parameters);
                } else {
                    $content = $this->container->call($action, $parameters);
                }
            } elseif (is_string($action)) {
                // Handle Class@method syntax if needed, otherwise fallback to container call
                if (str_contains($action, '@')) {
                    [$class, $method] = explode('@', $action);
                    $instance = $this->container->make($class);
                    $content = $this->container->call([$instance, $method], $parameters);
                } else {
                    $content = $this->container->call($action, $parameters);
                }
            } else {
                throw new \Exception('Invalid route action.');
            }

            return $this->prepareResponse($request, $content);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Prepare a response from the given value.
     *
     * @param Request $request
     * @param mixed $response
     * @return Response
     */
    public function prepareResponse($request, $response)
    {
        if ($response instanceof Response) {
            return $response;
        }

        return new Response($response);
    }
}
