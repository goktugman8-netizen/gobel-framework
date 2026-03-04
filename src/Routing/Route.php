<?php

namespace Gobel\Routing;

class Route
{
    /**
     * The URI pattern the route responds to.
     *
     * @var string
     */
    protected $uri;

    /**
     * The HTTP methods the route responds to.
     *
     * @var array
     */
    protected $methods;

    /**
     * The route action.
     *
     * @var mixed
     */
    protected $action;

    /**
     * The matching parameters for the route.
     *
     * @var array
     */
    protected $parameters = [];

    /**
     * The middlewares for the route.
     *
     * @var array
     */
    protected $middlewares = [];
    
    /**
     * The route name.
     *
     * @var string|null
     */
    protected $name;

    /**
     * Create a new Route instance.
     *
     * @param array|string $methods
     * @param string $uri
     * @param mixed $action
     */
    public function __construct($methods, string $uri, $action)
    {
        $this->methods = (array) $methods;
        $this->uri = '/' . ltrim($uri, '/');
        $this->action = $action;
    }

    /**
     * Determine if the route matches a given request.
     *
     * @param \Gobel\Http\Request $request
     * @return bool
     */
    public function matches(\Gobel\Http\Request $request)
    {
        if (!in_array($request->method(), $this->methods)) {
            return false;
        }

        $uri = '/' . ltrim($request->path(), '/');

        // Check for exact match
        if ($this->uri === $uri) {
            return true;
        }

        // Check for parameter match
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[a-zA-Z0-9_-]+)', $this->uri);
        $pattern = str_replace('/', '\/', $pattern);
        $pattern = '/^' . $pattern . '$/';

        if (preg_match($pattern, $uri, $matches)) {
            $this->parameters = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
            return true;
        }

        return false;
    }

    /**
     * Add middleware to the route.
     *
     * @param array|string $middleware
     * @return $this
     */
    public function middleware($middleware)
    {
        $this->middlewares = array_merge($this->middlewares, (array) $middleware);

        return $this;
    }

    /**
     * Name the route.
     *
     * @param string $name
     * @return $this
     */
    public function name(string $name)
    {
        $this->name = $name;
        
        return $this;
    }

    /**
     * Get the route parameters.
     *
     * @return array
     */
    public function parameters()
    {
        return $this->parameters;
    }

    /**
     * Get the route action.
     *
     * @return mixed
     */
    public function action()
    {
        return $this->action;
    }
    
    /**
     * Get the route name.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }
}
