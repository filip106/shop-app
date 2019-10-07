<?php

namespace src\Debug;

/**
 * Class Debug
 * @package src\Debug
 */
abstract class Debug
{
    /** @var bool */
    private static $enabled = false;

    /**
     * Enables the debug tools.
     *
     * @param int $errorReportingLevel The level of error reporting you want
     * @param bool $displayErrors      Whether to display errors (for development) or just log them (for production)
     */
    public static function enable($errorReportingLevel = E_ALL, $displayErrors = true)
    {
        if (static::$enabled) {
            return;
        }

        static::$enabled = true;

        if (null !== $errorReportingLevel) {
            error_reporting($errorReportingLevel);
        } else {
            error_reporting(E_ALL);
        }

        if ($displayErrors) {
            ini_set('display_errors', 1);
        }
    }
}