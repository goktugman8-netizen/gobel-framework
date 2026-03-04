<?php

namespace Gobel\Console;

class MakeModelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new database Model class';

    /**
     * Execute the console command.
     *
     * @param array $args
     * @return int
     */
    public function handle(array $args): int
    {
        if (empty($args)) {
            $this->error('Please provider a model name.');
            return 1;
        }

        $name = $args[0];
        $path = $this->app->basePath('app/Models/' . $name . '.php');

        if (file_exists($path)) {
            $this->error("Model [{$name}] already exists!");
            return 1;
        }

        $directory = dirname($path);
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        file_put_contents($path, $this->getStub($name));

        $this->info("Model [{$name}] created successfully.");

        return 0;
    }

    /**
     * Get the stub file for the generator.
     *
     * @param string $name
     * @return string
     */
    protected function getStub($name)
    {
        $namespace = 'App\\Models';
        $class = basename($name);

        // If the name contains subdirectories
        if (strpos($name, '/') !== false || strpos($name, '\\') !== false) {
            $name = str_replace('/', '\\', $name);
            $parts = explode('\\', $name);
            $class = array_pop($parts);
            $namespace .= '\\' . implode('\\', $parts);
        }

        return <<<PHP
<?php

namespace {$namespace};

use Gobel\Database\Model;

class {$class} extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    // protected \$table = '{$class}s';
}

PHP;
    }
}
