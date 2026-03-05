<?php

namespace Gobel\Session;

class Session
{
    /**
     * Start the session if not already started.
     *
     * @return void
     */
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Get a session value.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $this->getFlash($key) ?? $default;
    }

    /**
     * Set a session value.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Remove a session value.
     *
     * @param string $key
     * @return void
     */
    public function remove(string $key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * Set a flash value.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function flash(string $key, $value)
    {
        // Support dot notation for flashing
        if (str_contains($key, '.')) {
            $keys = explode('.', $key);
            $current = &$_SESSION['_flash']['next'];
            
            foreach ($keys as $k) {
                if (!isset($current[$k]) || !is_array($current[$k])) {
                    $current[$k] = [];
                }
                $current = &$current[$k];
            }
            
            $current = $value;
        } else {
            $_SESSION['_flash']['next'][$key] = $value;
        }
    }

    /**
     * Get a flash value.
     *
     * @param string $key
     * @return mixed
     */
    protected function getFlash(string $key)
    {
        return $_SESSION['_flash']['current'][$key] ?? null;
    }

    /**
     * Age the flash data.
     *
     * @return void
     */
    public function ageFlashData()
    {
        $_SESSION['_flash']['current'] = $_SESSION['_flash']['next'] ?? [];
        $_SESSION['_flash']['next'] = [];
    }

    /**
     * Get or generate a CSRF token.
     *
     * @return string
     */
    public function token()
    {
        if (! $this->get('_token')) {
            $this->set('_token', bin2hex(random_bytes(32)));
        }

        return $this->get('_token');
    }

    /**
     * Clear all session data.
     *
     * @return void
     */
    public function clear()
    {
        session_unset();
        session_destroy();
    }
}
