<?php

namespace Gobel\Console;

class DbSeedCommand extends Command
{
    /**
     * The command signature.
     *
     * @var string
     */
    protected $signature = 'db:seed';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with records';

    /**
     * Execute the command.
     *
     * @param array $args
     * @return int
     */
    public function handle(array $args): int
    {
        $class = !empty($args) ? $args[0] : 'Database\\Seeders\\DatabaseSeeder';

        if (!class_exists($class)) {
            $this->error("Seeder class [{$class}] not found.");
            return 1;
        }

        $this->info("Seeding: {$class}");

        $seeder = new $class();
        $seeder->run();

        $this->info("Database seeding completed successfully.");

        return 0;
    }
}
