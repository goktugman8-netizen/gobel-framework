<?php

namespace Gobel\Console;

class MakeNotificationCommand extends Command
{
    /**
     * The command signature.
     *
     * @var string
     */
    protected $signature = 'make:notification';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'Create a new notification class';

    /**
     * Execute the command.
     *
     * @param array $args
     * @return int
     */
    public function handle(array $args): int
    {
        if (empty($args)) {
            $this->error('Please provide a notification name.');
            return 1;
        }

        $name = $args[0];
        $path = $this->app->basePath('app/Notifications/' . $name . '.php');

        if (file_exists($path)) {
            $this->error("Notification [{$name}] already exists!");
            return 1;
        }

        $directory = dirname($path);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        file_put_contents($path, $this->stub($name));

        $this->info("Notification [{$name}] created successfully.");

        return 0;
    }

    protected function stub($name)
    {
        return <<<PHP
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class {$name} extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  \$notifiable
     * @return array
     */
    public function via(\$notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  \$notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail(\$notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  \$notifiable
     * @return array
     */
    public function toArray(\$notifiable)
    {
        return [
            //
        ];
    }
}
PHP;
    }
}
