<?php

use Gobel\Foundation\Application;
use Gobel\View\View;

if (! function_exists('app')) {
    /**
     * Get the available container instance.
     *
     * @param string|null $abstract
     * @param array $parameters
     * @return mixed|\Gobel\Foundation\Application
     */
    function app($abstract = null, array $parameters = [])
    {
        if (is_null($abstract)) {
            return \Gobel\Foundation\Application::getInstance();
        }

        return \Gobel\Foundation\Application::getInstance()->make($abstract, $parameters);
    }
}

if (! function_exists('env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

        if ($value === false) {
            return $default;
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return null;
        }

        return $value;
    }
}

if (! function_exists('now')) {
    /**
     * Create a new Carbon instance for the current time.
     *
     * @param \DateTimeZone|string|null $tz
     * @return \Carbon\Carbon
     */
    function now($tz = null)
    {
        return \Carbon\Carbon::now($tz);
    }
}

if (! function_exists('dd')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param  mixed  $vars
     * @return void
     */
    function dd(...$vars)
    {
        foreach ($vars as $v) {
            dump($v);
        }

        die(1);
    }
}

if (! function_exists('dump')) {
    /**
     * Dump the passed variables.
     *
     * @param  mixed  $vars
     * @return void
     */
    function dump(...$vars)
    {
        foreach ($vars as $v) {
            if (function_exists('Symfony\Component\VarDumper\VarDumper::dump')) {
                \Symfony\Component\VarDumper\VarDumper::dump($v);
            } else {
                var_dump($v);
            }
        }
    }
}

if (! function_exists('view')) {
    /**
     * Get the evaluated view contents for the given view.
     *
     * @param string|null $view
     * @param array $data
     * @return \Illuminate\Http\Response|string
     */
    function view($view = null, $data = [])
    {
        $factory = app(\Gobel\View\View::class);

        if (func_num_args() === 0) {
            return $factory;
        }

        $content = $factory->make($view, $data);
        
        return new \Illuminate\Http\Response($content);
    }
}

if (! function_exists('csrf_token')) {
    /**
     * Get the CSRF token value.
     *
     * @return string
     */
    function csrf_token()
    {
        return app(\Gobel\Session\Session::class)->token();
    }
}

if (! function_exists('csrf_field')) {
    /**
     * Get the CSRF token HTML field.
     *
     * @return string
     */
    function csrf_field()
    {
        return '<input type="hidden" name="_token" value="' . csrf_token() . '">';
    }
}

if (! function_exists('redirect')) {
    /**
     * Get an instance of the redirector.
     *
     * @param string|null $to
     * @param int $status
     * @param array $headers
     * @return \Gobel\Http\RedirectResponse
     */
    function redirect($to = null, $status = 302, array $headers = [])
    {
        return new \Gobel\Http\RedirectResponse($to, $status, $headers);
    }
}

if (! function_exists('session')) {
    /**
     * Get / set the specified session value.
     *
     * @param string|array|null $key
     * @param mixed $default
     * @return mixed|\Gobel\Session\Session
     */
    function session($key = null, $default = null)
    {
        if (is_null($key)) {
            return app(\Gobel\Session\Session::class);
        }

        if (is_array($key)) {
            foreach ($key as $k => $v) {
                app(\Gobel\Session\Session::class)->set($k, $v);
            }
            return null;
        }

        return app(\Gobel\Session\Session::class)->get($key, $default);
    }
}

if (! function_exists('auth')) {
    /**
     * Get the available auth instance.
     *
     * @return \Gobel\Auth\Auth
     */
    function auth()
    {
        return app(\Gobel\Auth\Auth::class);
    }
}

if (! function_exists('logger')) {
    /**
     * Log a message.
     *
     * @param string|null $message
     * @param string $level
     * @return \Gobel\Log\Logger|void
     */
    function logger($message = null, $level = 'info')
    {
        $logger = app(\Gobel\Log\Logger::class);

        if (is_null($message)) {
            return $logger;
        }

        $logger->$level($message);
    }
}

if (! function_exists('hash')) {
    /**
     * Get the hasher instance.
     *
     * @return \Gobel\Support\Hash
     */
    function hash()
    {
        return app(\Gobel\Support\Hash::class);
    }
}

if (! function_exists('config')) {
    /**
     * Get / set the specified configuration value.
     *
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    function config($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('config');
        }

        return app('config')->get($key, $default);
    }
}

if (! function_exists('db')) {
    /**
     * Get the database connection or a query builder for a table.
     *
     * @param string|null $table
     * @return \Illuminate\Database\Connection|\Illuminate\Database\Query\Builder
     */
    function db($table = null)
    {
        $db = app('db');

        if (is_null($table)) {
            return $db->getConnection();
        }

        return $db->table($table);
    }
}

if (! function_exists('collect')) {
    /**
     * Create a collection from the given value.
     *
     * @param  mixed  $value
     * @return \Illuminate\Support\Collection
     */
    function collect($value = null)
    {
        return new \Illuminate\Support\Collection($value);
    }
}

if (! function_exists('back')) {
    /**
     * Create a new redirect response to the previous location.
     *
     * @param  int  $status
     * @param  array  $headers
     * @return \Gobel\Http\RedirectResponse
     */
    function back($status = 302, $headers = [])
    {
        $request = app('request');
        $url = $request->header('referer') ?? '/';
        
        return new \Gobel\Http\RedirectResponse($url, $status, $headers);
    }
}

if (! function_exists('old')) {
    /**
     * Retrieve an old input item from the session.
     *
     * @param  string|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    function old($key = null, $default = null)
    {
        $session = app(\Gobel\Session\Session::class);
        $oldInput = $session->get('_old_input') ?? [];

        if (is_null($key)) {
            return $oldInput;
        }

        return $oldInput[$key] ?? $default;
    }
}
