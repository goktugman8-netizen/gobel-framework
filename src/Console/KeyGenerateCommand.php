<?php

namespace Gobel\Console;

class KeyGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'key:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the application key (JWT_SECRET) in the .env file';

    /**
     * Execute the console command.
     *
     * @param array $args
     * @return int
     */
    public function handle(array $args): int
    {
        $key = $this->generateRandomKey();

        if (!$this->setKeyInEnvironmentFile($key)) {
            $this->error('Failed to set application key. Make sure .env exists.');
            return 1;
        }

        $this->info('Application key set successfully.');
        echo "JWT_SECRET: $key" . PHP_EOL;

        return 0;
    }

    /**
     * Generate a random key.
     *
     * @return string
     */
    protected function generateRandomKey()
    {
        return 'base64:' . base64_encode(random_bytes(32));
    }

    /**
     * Set the application key in the environment file.
     *
     * @param string $key
     * @return bool
     */
    protected function setKeyInEnvironmentFile($key)
    {
        $envPath = $this->app->basePath('.env');

        if (!file_exists($envPath)) {
            return false;
        }

        $content = file_get_contents($envPath);

        if (str_contains($content, 'JWT_SECRET=')) {
            $content = preg_replace('/^JWT_SECRET=.*$/m', 'JWT_SECRET=' . $key, $content);
        } else {
            $content .= "\nJWT_SECRET=" . $key . "\n";
        }

        file_put_contents($envPath, $content);

        return true;
    }
}
