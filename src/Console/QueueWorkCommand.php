<?php

namespace Gobel\Console;

use Illuminate\Queue\Worker;
use Illuminate\Queue\WorkerOptions;

class QueueWorkCommand extends Command
{
    /**
     * The command signature.
     *
     * @var string
     */
    protected $signature = 'queue:work';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'Start processing jobs on the queue as a worker';

    /**
     * Execute the command.
     *
     * @param array $args
     * @return int
     */
    public function handle(array $args): int
    {
        $this->info('Queue worker started...');

        $worker = $this->app->make('queue.worker');

        return $worker->daemon(
            'default', 'default', new WorkerOptions()
        );
    }
}
