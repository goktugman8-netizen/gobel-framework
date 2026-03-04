<?php

namespace Gobel\Console;

use Gobel\Support\Facades\DB;

class MigrateRollbackCommand extends Command
{
    /**
     * The command signature.
     *
     * @var string
     */
    protected $signature = 'migrate:rollback';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'Rollback the last database migration batch';

    /**
     * Execute the command.
     *
     * @param array $args
     * @return int
     */
    public function handle(array $args): int
    {
        $batch = DB::table('migrations')->max('batch');

        if (!$batch) {
            $this->info("Nothing to rollback.");
            return 0;
        }

        $migrations = DB::table('migrations')
            ->where('batch', $batch)
            ->orderBy('migration', 'desc')
            ->get();

        foreach ($migrations as $migration) {
            $this->rollbackMigration($migration->migration);
        }

        $this->info("Rollback completed successfully.");

        return 0;
    }

    /**
     * Rollback an individual migration.
     *
     * @param string $migration
     * @return void
     */
    protected function rollbackMigration($migration)
    {
        $path = $this->app->basePath('database/migrations/' . $migration . '.php');
        $instance = require $path;

        $instance->down();

        DB::table('migrations')->where('migration', $migration)->delete();

        $this->info("Rolled back: {$migration}");
    }
}
