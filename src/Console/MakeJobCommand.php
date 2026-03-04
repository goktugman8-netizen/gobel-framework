<?php

namespace Gobel\Console;

class MakeJobCommand extends Command
{
    /**
     * The command signature.
     *
     * @var string
     */
    protected $signature = 'make:job';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'Create a new job class';

    /**
     * Execute the command.
     *
     * @param array $args
     * @return int
     */
    public function handle(array $args): int
    {
        if (empty($args)) {
            $this->error('Please provide a job name.');
            return 1;
        }

        $name = $args[0];
        $path = $this->app->basePath('app/Jobs/' . $name . '.php');

        if (file_exists($path)) {
            $this->error("Job [{$name}] already exists!");
            return 1;
        }

        $directory = dirname($path);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        file_put_contents($path, $this->stub($name));

        $this->info("Job [{$name}] created successfully.");

        return 0;
    }

    protected function stub($name)
    {
        return <<<PHP
<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class {$name} implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}
PHP;
    }
}
