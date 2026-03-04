<?php

namespace Gobel\Http;

class RedirectResponse extends Response
{
    /**
     * Create a new redirect response instance.
     *
     * @param string $url
     * @param int $status
     * @param array $headers
     */
    public function __construct(string $url, int $status = 302, array $headers = [])
    {
        parent::__construct('', $status, $headers);
        $this->header('Location', $url);
    }

    /**
     * Flash a piece of data to the session.
     *
     * @param string|array $key
     * @param mixed $value
     * @return $this
     */
    public function with($key, $value = null)
    {
        $session = app(\Gobel\Session\Session::class);

        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $session->flash($k, $v);
            }
        } else {
            $session->flash($key, $value);
        }

        return $this;
    }
}
