<?php

namespace Gobel\Support\Facades;

class Redis extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'redis';
    }
}
