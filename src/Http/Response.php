<?php

namespace Gobel\Http;

class Response
{
    /**
     * @var string
     */
    protected $content;

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var array
     */
    protected $headers;

    /**
     * HTTP status codes and their default phrases.
     */
    public static $statusTexts = [
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        204 => 'No Content',
        301 => 'Moved Permanently',
        302 => 'Found',
        304 => 'Not Modified',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        500 => 'Internal Server Error',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
    ];

    /**
     * Create a new Response instance.
     *
     * @param mixed $content
     * @param int $status
     * @param array $headers
     */
    public function __construct($content = '', int $status = 200, array $headers = [])
    {
        $this->setContent($content);
        $this->statusCode = $status;
        $this->headers = $headers;
    }

    /**
     * Set the response content.
     *
     * @param mixed $content
     * @return $this
     */
    public function setContent($content)
    {
        if (is_array($content) || is_object($content)) {
            $this->content = json_encode($content);
            $this->header('Content-Type', 'application/json');
        } else {
            $this->content = (string) $content;
        }

        return $this;
    }

    /**
     * Get the response content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the response status code.
     *
     * @param int $statusCode
     * @return $this
     */
    public function setStatusCode(int $statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Get the response status code.
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Add a header to the response.
     *
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function header(string $key, string $value)
    {
        $this->headers[$key] = $value;

        return $this;
    }

    /**
     * Get all response headers.
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Send the HTTP response headers and content.
     *
     * @return void
     */
    public function send()
    {
        $this->sendHeaders();
        $this->sendContent();
    }

    /**
     * Send HTTP headers.
     *
     * @return $this
     */
    protected function sendHeaders()
    {
        // Headers have already been sent by the developer
        if (headers_sent()) {
            return $this;
        }

        $protocol = $_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.1';
        $statusText = self::$statusTexts[$this->statusCode] ?? 'Unknown Status';

        header(sprintf('%s %s %s', $protocol, $this->statusCode, $statusText), true, $this->statusCode);

        foreach ($this->headers as $name => $value) {
            header($name . ': ' . $value, true, $this->statusCode);
        }

        return $this;
    }

    /**
     * Send content.
     *
     * @return $this
     */
    protected function sendContent()
    {
        echo $this->content;

        return $this;
    }
}
