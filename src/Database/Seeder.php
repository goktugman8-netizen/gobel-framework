<?php

namespace Gobel\Database;

use Faker\Factory as FakerFactory;
use Gobel\Foundation\Application;

abstract class Seeder
{
    /**
     * The application instance.
     *
     * @var Application
     */
    protected $app;

    /**
     * The Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     */
    public function __construct()
    {
        $this->app = Application::getInstance();
        $this->faker = FakerFactory::create();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    abstract public function run();

    /**
     * Seed the given seeder class.
     *
     * @param string $class
     * @return void
     */
    public function call(string $class)
    {
        $seeder = new $class();
        $seeder->run();
    }
}
