<?php

namespace Gobel\Support\Facades;

use Gobel\Foundation\Application;

class Lang
{
    /**
     * Handle dynamic static method calls into the Translator.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        return Application::getInstance()->make('translator')->$method(...$parameters);
    }
}
