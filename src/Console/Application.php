<?php

namespace Gobel\Console;

use Gobel\Foundation\Application as BaseApplication;

class Application
{
    /**
     * The application instance.
     *
     * @var BaseApplication
     */
    protected $app;

    /**
     * The registered commands.
     *
     * @var array
     */
    protected $commands = [];

    /**
     * Create a new console application instance.
     *
     * @param BaseApplication $app
     */
    public function __construct(BaseApplication $app)
    {
        $this->app = $app;
        $this->registerCoreCommands();
    }

    /**
     * Register a new console command.
     *
     * @param Command $command
     * @return void
     */
    public function add(Command $command)
    {
        $command->setApplication($this->app);
        $this->commands[$command->getSignature()] = $command;
    }
    
    /**
     * Register core commands.
     * 
     * @return void
     */
    protected function registerCoreCommands()
    {
        $this->add(new \Gobel\Console\MakeControllerCommand);
        $this->add(new \Gobel\Console\MakeModelCommand);
        $this->add(new \Gobel\Console\MakeMigrationCommand);
        $this->add(new \Gobel\Console\MigrateCommand);
        $this->add(new \Gobel\Console\MigrateRollbackCommand);
        $this->add(new \Gobel\Console\MakeSeederCommand);
        $this->add(new \Gobel\Console\DbSeedCommand);
        $this->add(new \Gobel\Console\MakeAuthCommand);
        $this->add(new \Gobel\Console\MakeRequestCommand);
        $this->add(new \Gobel\Console\MakeJobCommand);
        $this->add(new \Gobel\Console\MakeNotificationCommand);
        $this->add(new \Gobel\Console\QueueWorkCommand);
        $this->add(new \Gobel\Console\MakePolicyCommand);
        $this->add(new \Gobel\Console\MakeResourceCommand);
        $this->add(new \Gobel\Console\KeyGenerateCommand);
        $this->add(new \Gobel\Console\ScheduleRunCommand);
    }

    /**
     * Run the console application.
     *
     * @param array $argv
     * @return int
     */
    public function run(array $argv)
    {
        array_shift($argv); // Remove script name (gobel)

        if (empty($argv)) {
            $this->listCommands();
            return 0;
        }

        $commandName = array_shift($argv);

        if (!isset($this->commands[$commandName])) {
            echo "\033[31mCommand \"{$commandName}\" is not defined.\033[0m" . PHP_EOL;
            return 1;
        }

        $command = $this->commands[$commandName];

        try {
            return $command->handle($argv);
        } catch (\Exception $e) {
            echo "\033[31m[Exception] " . $e->getMessage() . "\033[0m" . PHP_EOL;
            return 1;
        }
    }

    /**
     * List all available commands.
     *
     * @return void
     */
    protected function listCommands()
    {
        echo "\033[32mGobel Framework\033[0m " . $this->app->version() . PHP_EOL . PHP_EOL;
        echo "\033[33mUsage:\033[0m" . PHP_EOL;
        echo "  command [arguments]" . PHP_EOL . PHP_EOL;
        echo "\033[33mAvailable commands:\033[0m" . PHP_EOL;

        foreach ($this->commands as $signature => $command) {
            echo "  \033[32m" . str_pad($signature, 20) . "\033[0m" . $command->getDescription() . PHP_EOL;
        }
    }
}
