<?php

namespace Gobel\Support;

use Illuminate\Hashing\HashManager;
use Gobel\Foundation\Application;

class Hash
{
    /**
     * The hash manager instance.
     *
     * @var HashManager
     */
    protected $manager;

    /**
     * Create a new hash instance.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->manager = new HashManager($app);
    }

    /**
     * Hash the given value.
     *
     * @param string $value
     * @param array $options
     * @return string
     */
    public function make(string $value, array $options = []): string
    {
        return $this->manager->make($value, $options);
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param string $value
     * @param string $hashedValue
     * @param array $options
     * @return bool
     */
    public function check(string $value, string $hashedValue, array $options = []): bool
    {
        return $this->manager->check($value, $hashedValue, $options);
    }

    /**
     * Handle dynamic calls to the manager.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->manager->$method(...$parameters);
    }
}
