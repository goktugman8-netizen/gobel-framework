<?php

namespace Gobel\Container;

use Illuminate\Container\Container as IlluminateContainer;

class Container extends IlluminateContainer
{
    /**
     * Get the globally available instance of the container.
     *
     * @return static
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * Determine if the given abstract type has been bound.
     *
     * @param string $abstract
     * @return bool
     */
    public function has(string $abstract): bool
    {
        return $this->bound($abstract);
    }
}
