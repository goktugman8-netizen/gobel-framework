<?php

namespace Gobel\Console;

class MakeMigrationCommand extends Command
{
    /**
     * The command signature.
     *
     * @var string
     */
    protected $signature = 'make:migration';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'Create a new migration file';

    /**
     * Execute the command.
     *
     * @param array $args
     * @return int
     */
    public function handle(array $args): int
    {
        if (empty($args)) {
            $this->error('Please provide a migration name.');
            return 1;
        }

        $name = $args[0];
        $timestamp = date('Y_m_d_His');
        $filename = "{$timestamp}_{$name}.php";
        
        $directory = $this->app->basePath('database/migrations');
        
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $path = $directory . '/' . $filename;

        if (file_exists($path)) {
            $this->error("Migration already exists!");
            return 1;
        }

        file_put_contents($path, $this->stub());

        $this->info("Migration created successfully: {$filename}");

        return 0;
    }

    /**
     * Get the migration stub.
     *
     * @return string
     */
    protected function stub()
    {
        return <<<'EOD'
<?php

use Gobel\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('table_name', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('table_name');
    }
};
EOD;
    }
}
