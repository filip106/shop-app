<?php

namespace src\Session;

class Session
{

    /**
     * @var Session
     */
    private static $instance;

    /**
     * Session constructor.
     */
    public function __construct()
    {
        session_start();
    }

    /**
     * @return Session
     */
    public static function getInstance(): Session
    {
        if (null === self::$instance) {
            self::$instance = new Session();
        }

        return self::$instance;
    }

    /**
     * @return string
     */
    public function sessionId()
    {
        return session_id();
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return Session
     */
    public function put(string $key, $value)
    {
        $_SESSION[$key] = $value;

        return $this;
    }

    /**
     * @param string $key
     * @param bool $defaultValue
     *
     * @return bool
     */
    public function get(string $key, $defaultValue = false)
    {
        return $_SESSION[$key] ?? $defaultValue;
    }

    /**
     * @param string $key
     *
     * @return $this
     */
    public function delete(string $key)
    {
        unset($_SESSION[$key]);

        return $this;
    }

    /**
     * @return bool
     */
    public function invalidateSession()
    {
        return session_destroy();
    }

    /**
     * @return bool
     */
    public function destroySession()
    {
        return session_destroy();
    }
}