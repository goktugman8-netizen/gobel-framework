<?php

namespace Gobel\Log;

class Logger
{
    /**
     * The log file path.
     *
     * @var string
     */
    protected $path;

    /**
     * Create a new logger instance.
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
        
        $directory = dirname($path);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
    }

    /**
     * Log an info message.
     *
     * @param string $message
     * @return void
     */
    public function info(string $message)
    {
        $this->log('INFO', $message);
    }

    /**
     * Log an error message.
     *
     * @param string $message
     * @return void
     */
    public function error(string $message)
    {
        $this->log('ERROR', $message);
    }

    /**
     * Log a warning message.
     *
     * @param string $message
     * @return void
     */
    public function warning(string $message)
    {
        $this->log('WARNING', $message);
    }

    /**
     * Write the message to the log file.
     *
     * @param string $level
     * @param string $message
     * @return void
     */
    protected function log(string $level, string $message)
    {
        $date = date('Y-m-d H:i:s');
        $format = "[{$date}] [{$level}]: {$message}" . PHP_EOL;
        
        file_put_contents($this->path, $format, FILE_APPEND);
    }
}
