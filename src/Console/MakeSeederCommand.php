<?php

namespace Gobel\Console;

class MakeSeederCommand extends Command
{
    /**
     * The command signature.
     *
     * @var string
     */
    protected $signature = 'make:seeder';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'Create a new seeder class';

    /**
     * Execute the command.
     *
     * @param array $args
     * @return int
     */
    public function handle(array $args): int
    {
        if (empty($args)) {
            $this->error('Please provide a seeder name.');
            return 1;
        }

        $name = $args[0];
        $path = $this->app->basePath('database/seeders/' . $name . '.php');

        if (file_exists($path)) {
            $this->error("Seeder [{$name}] already exists!");
            return 1;
        }

        $directory = dirname($path);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        file_put_contents($path, $this->stub($name));

        $this->info("Seeder [{$name}] created successfully.");

        return 0;
    }

    /**
     * Get the seeder stub.
     *
     * @param string $name
     * @return string
     */
    protected function stub($name)
    {
        return <<<PHP
<?php

namespace Database\Seeders;

use Gobel\Database\Seeder;
use Gobel\Support\Facades\DB;

class {$name} extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     'name' => \$this->faker->name,
        //     'email' => \$this->faker->unique()->safeEmail,
        //     'password' => password_hash('password', PASSWORD_BCRYPT),
        // ]);
    }
}
PHP;
    }
}
