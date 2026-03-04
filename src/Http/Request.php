<?php

namespace Gobel\Http;

class Request
{
    /**
     * @var array
     */
    protected $query;

    /**
     * @var array
     */
    protected $request;

    /**
     * @var array
     */
    protected $attributes;

    /**
     * @var array
     */
    protected $cookies;

    /**
     * @var array
     */
    protected $files;

    /**
     * @var array
     */
    protected $server;

    /**
     * Create a new Request instance.
     *
     * @param array $query
     * @param array $request
     * @param array $attributes
     * @param array $cookies
     * @param array $files
     * @param array $server
     */
    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [])
    {
        $this->query = $query;
        $this->request = $request;
        $this->attributes = $attributes;
        $this->cookies = $cookies;
        $this->files = $files;
        $this->server = $server;
    }

    /**
     * Capture the current incoming request.
     *
     * @return static
     */
    public static function capture()
    {
        return new static($_GET, $_POST, [], $_COOKIE, $_FILES, $_SERVER);
    }

    /**
     * Get the request method.
     *
     * @return string
     */
    public function method()
    {
        return $this->server['REQUEST_METHOD'] ?? 'GET';
    }

    /**
     * Get the request URI.
     *
     * @return string
     */
    public function uri()
    {
        $uri = $this->server['REQUEST_URI'] ?? '/';
        
        // Strip query string
        if ($pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        // Handle subdirectories (XAMPP)
        // If we are in a subdirectory like /myproject/, we need to strip it.
        $scriptName = $this->server['SCRIPT_NAME'] ?? '';
        $baseDir = dirname($scriptName); // e.g. /myproject/public
        
        // If the SCRIPT_NAME is /public/index.php, baseDir is /public
        // If the SCRIPT_NAME is /index.php, baseDir is /
        
        // Let's normalize baseDir
        $baseDir = str_replace('\\', '/', $baseDir);
        if ($baseDir === '.') $baseDir = '/';

        // Remove the base directory from the URI
        if ($baseDir !== '/' && strpos($uri, $baseDir) === 0) {
            $uri = substr($uri, strlen($baseDir));
        }
        
        // Also check if we redirected from root but kept /public/ in URI
        if (strpos($uri, '/public/') === 0) {
            $uri = substr($uri, 7);
        }

        return '/' . trim($uri, '/');
    }

    /**
     * Get the request URL Path.
     *
     * @return string
     */
    public function path()
    {
        $uri = $this->uri();
        return $uri === '' ? '/' : $uri;
    }

    /**
     * Get an input value.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function input($key, $default = null)
    {
        return $this->request[$key] ?? $this->query[$key] ?? $default;
    }

    /**
     * Get all input values.
     *
     * @return array
     */
    public function all()
    {
        return array_merge($this->query, $this->request);
    }

    /**
     * Get an attribute value.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function attribute($key, $default = null)
    {
        return $this->attributes[$key] ?? $default;
    }

    /**
     * Set an attribute value.
     *
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * Retrieve a server variable from the request.
     *
     * @param  string|null  $key
     * @param  string|array|null  $default
     * @return string|array|null
     */
    public function server($key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->server;
        }

        return $this->server[$key] ?? $default;
    }

    /**
     * Determine if the request contains a given input item.
     *
     * @param  string|array  $key
     * @return bool
     */
    public function has($key)
    {
        $keys = is_array($key) ? $key : func_get_args();

        foreach ($keys as $k) {
            if (!array_key_exists($k, $this->all())) {
                return false;
            }
        }

        return true;
    }

    /**
     * Magic getter for input data.
     */
    public function __get($key)
    {
        return $this->all()[$key] ?? null;
    }
}
