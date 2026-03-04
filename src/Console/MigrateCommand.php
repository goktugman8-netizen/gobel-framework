<?php

namespace Gobel\Console;

use Gobel\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Gobel\Support\Facades\DB;

class MigrateCommand extends Command
{
    /**
     * The command signature.
     *
     * @var string
     */
    protected $signature = 'migrate';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'Run the database migrations';

    /**
     * Execute the command.
     *
     * @param array $args
     * @return int
     */
    public function handle(array $args): int
    {
        $this->ensureMigrationsTableExists();

        $files = $this->getMigrationFiles();
        $ran = $this->getRanMigrations();

        $toRun = array_diff($files, $ran);

        if (empty($toRun)) {
            $this->info("Nothing to migrate.");
            return 0;
        }

        foreach ($toRun as $file) {
            $this->runMigration($file);
        }

        $this->info("Migrations completed successfully.");

        return 0;
    }

    /**
     * Ensure the migrations tracking table exists.
     *
     * @return void
     */
    protected function ensureMigrationsTableExists()
    {
        if (!Schema::hasTable('migrations')) {
            Schema::create('migrations', function (Blueprint $table) {
                $table->id();
                $table->string('migration');
                $table->integer('batch');
            });
        }
    }

    /**
     * Get all migration files.
     *
     * @return array
     */
    protected function getMigrationFiles()
    {
        $directory = $this->app->basePath('database/migrations');
        if (!is_dir($directory)) return [];

        $files = glob($directory . '/*.php');
        
        $files = array_map(function($file) {
            return basename($file, '.php');
        }, $files);

        sort($files);

        return $files;
    }

    /**
     * Get the migrations that have already run.
     *
     * @return array
     */
    protected function getRanMigrations()
    {
        return DB::table('migrations')->pluck('migration')->toArray();
    }

    /**
     * Run an individual migration.
     *
     * @param string $migration
     * @return void
     */
    protected function runMigration($migration)
    {
        $path = $this->app->basePath('database/migrations/' . $migration . '.php');
        $instance = require $path;

        $batch = DB::table('migrations')->max('batch') + 1;

        $instance->up();

        DB::table('migrations')->insert([
            'migration' => $migration,
            'batch' => $batch
        ]);

        $this->info("Migrated: {$migration}");
    }
}
