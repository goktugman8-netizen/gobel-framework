<?php

namespace Gobel\Foundation;

use Illuminate\Container\Container as IlluminateContainer;
use Illuminate\Support\Facades\Facade;

class Application extends IlluminateContainer
{
    /**
     * The Gobel framework version.
     *
     * @var string
     */
    const VERSION = '1.0.0';

    /**
     * The base path for the application installation.
     *
     * @var string
     */
    protected $basePath;

    /**
     * All of the registered service providers.
     *
     * @var \Gobel\Support\ServiceProvider[]
     */
    protected $serviceProviders = [];

    /**
     * The names of the loaded service providers.
     *
     * @var array
     */
    protected $loadedProviders = [];

    /**
     * Indicates if the application has been "booted".
     *
     * @var bool
     */
    protected $booted = false;

    /**
     * Create a new Gobel application instance.
     *
     * @param string|null $basePath
     * @return void
     */
    public function __construct(string $basePath)
    {
        $this->basePath = rtrim($basePath, '\/');

        $this->bootstrapEnvironment();
        $this->registerBaseBindings();
        $this->registerPathBindings();
    }

    /**
     * Bootstrap the application environment.
     *
     * @return void
     */
    protected function bootstrapEnvironment()
    {
        if (file_exists($this->basePath . '/.env')) {
            $dotenv = \Dotenv\Dotenv::createImmutable($this->basePath);
            $dotenv->load();
        }
    }

    /**
     * Set the base path for the application.
     *
     * @param string $basePath
     * @return $this
     */
    public function setBasePath($basePath)
    {
        $this->basePath = rtrim($basePath, '\/');

        $this->bindPathsInContainer();

        return $this;
    }

    /**
     * Bind all of the application paths in the container.
     *
     * @return void
     */
    protected function registerPathBindings()
    {
        $this->instance('path.base', $this->basePath());
        $this->instance('path.config', $this->configPath());
        $this->instance('path.public', $this->publicPath());
        $this->instance('path.resources', $this->resourcePath());
        $this->instance('path.storage', $this->storagePath());
    }

    /**
     * Get the base path of the Laravel installation.
     *
     * @param string $path
     * @return string
     */
    public function basePath($path = '')
    {
        return $this->basePath . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Get the path to the application configuration files.
     *
     * @param string $path
     * @return string
     */
    public function configPath($path = '')
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'config' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Get the path to the public / web directory.
     *
     * @return string
     */
    public function publicPath()
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'public';
    }

    /**
     * Get the path to the resources directory.
     *
     * @param string $path
     * @return string
     */
    public function resourcePath($path = '')
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'resources' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Get the path to the storage directory.
     *
     * @param string $path
     * @return string
     */
    public function storagePath($path = '')
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'storage' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Register the basic bindings into the container.
     *
     * @return void
     */
    protected function registerBaseBindings()
    {
        static::setInstance($this);
        Facade::setFacadeApplication($this);

        $this->instance('app', $this);
        $this->instance(IlluminateContainer::class, $this);
        $this->instance(static::class, $this);
        $this->instance(Application::class, $this);
    }

    /**
     * Get the version number of the application.
     *
     * @return string
     */
    public function version()
    {
        return static::VERSION;
    }

    /**
     * Register a service provider with the application.
     *
     * @param \Gobel\Support\ServiceProvider|string $provider
     * @return \Gobel\Support\ServiceProvider
     */
    public function register($provider)
    {
        if (is_string($provider)) {
            $provider = new $provider($this);
        }

        if (isset($this->loadedProviders[get_class($provider)])) {
            return $this->loadedProviders[get_class($provider)];
        }

        $provider->register();

        $this->serviceProviders[] = $provider;
        $this->loadedProviders[get_class($provider)] = $provider;

        if ($this->booted) {
            $provider->boot();
        }

        return $provider;
    }

    /**
     * Boot the application's service providers.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->booted) {
            return;
        }

        foreach ($this->serviceProviders as $provider) {
            $provider->boot();
        }

        $this->booted = true;
    }
}
