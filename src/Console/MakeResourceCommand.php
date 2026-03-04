<?php

namespace Gobel\Console;

class MakeResourceCommand extends Command
{
    /**
     * The command signature.
     *
     * @var string
     */
    protected $signature = 'make:resource';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'Create a new API resource class';

    /**
     * Execute the command.
     *
     * @param array $args
     * @return int
     */
    public function handle(array $args): int
    {
        if (empty($args)) {
            $this->error('Please provide a resource name.');
            return 1;
        }

        $name = $args[0];
        $path = $this->app->basePath('app/Resources/' . $name . '.php');

        if (file_exists($path)) {
            $this->error("Resource [{$name}] already exists!");
            return 1;
        }

        $directory = dirname($path);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        file_put_contents($path, $this->stub($name));

        $this->info("Resource [{$name}] created successfully.");

        return 0;
    }

    protected function stub($name)
    {
        return <<<PHP
<?php

namespace App\Resources;

use Gobel\Http\Resources\JsonResource;

class {$name} extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => \$this->resource->id,
            // 'attribute' => \$this->resource->attribute,
        ];
    }
}
PHP;
    }
}
