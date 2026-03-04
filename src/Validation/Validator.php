<?php

namespace Gobel\Validation;

use Illuminate\Validation\Factory as ValidationFactory;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Filesystem\Filesystem;
use Gobel\Foundation\Application;

class Validator
{
    /**
     * The validation factory instance.
     *
     * @var ValidationFactory
     */
    protected $factory;

    /**
     * Create a new validator instance.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $loader = new FileLoader(new Filesystem(), $app->resourcePath('lang'));
        $translator = new Translator($loader, 'en');
        $this->factory = new ValidationFactory($translator, $app);
    }

    /**
     * Validate the given data against the rules.
     *
     * @param array $data
     * @param array $rules
     * @param array $messages
     * @param array $attributes
     * @return \Illuminate\Validation\Validator
     */
    public function make(array $data, array $rules, array $messages = [], array $attributes = [])
    {
        return $this->factory->make($data, $rules, $messages, $attributes);
    }

    /**
     * Validate the given data against the rules.
     *
     * @param array $data
     * @param array $rules
     * @return bool
     */
    public function validate(array $data, array $rules): bool
    {
        return !$this->make($data, $rules)->fails();
    }
}
