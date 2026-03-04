<?php

namespace Gobel\Console;

class ScheduleRunCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the scheduled commands';

    /**
     * Execute the console command.
     *
     * @param array $args
     * @return int
     */
    public function handle(array $args): int
    {
        $this->info('Running scheduled tasks...');

        $scheduler = $this->app->make(\Illuminate\Console\Scheduling\Schedule::class);
        
        $events = $scheduler->dueEvents($this->app);

        foreach ($events as $event) {
            $this->info("Running: " . $event->getSummaryForDisplay());
            $event->run($this->app);
        }

        if (count($events) === 0) {
            $this->info('No scheduled commands are ready to run.');
        }

        return 0;
    }
}
