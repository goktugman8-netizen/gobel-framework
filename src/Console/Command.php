<?php

namespace Gobel\Console;

abstract class Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description;

    /**
     * The application instance.
     *
     * @var \Gobel\Foundation\Application
     */
    protected $app;

    /**
     * Set the application instance.
     *
     * @param \Gobel\Foundation\Application $app
     * @return void
     */
    public function setApplication($app)
    {
        $this->app = $app;
    }

    /**
     * Execute the console command.
     *
     * @param array $args
     * @return int
     */
    abstract public function handle(array $args): int;

    /**
     * Output info message.
     *
     * @param string $message
     * @return void
     */
    protected function info($message)
    {
        echo "\033[32m{$message}\033[0m" . PHP_EOL;
    }

    /**
     * Output error message.
     *
     * @param string $message
     * @return void
     */
    protected function error($message)
    {
        echo "\033[31m{$message}\033[0m" . PHP_EOL;
    }

    /**
     * Get the command signature.
     *
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * Get the command description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
