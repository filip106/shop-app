<?php
/**
 * Created by PhpStorm.
 * User: Aleksandra
 * Date: 30-Sep-19
 * Time: 3:57 PM
 */

namespace src\Authorization;

class RequestStack
{
    /** @var RequestStack */
    private static $instance;

    /** @var Request[] */
    private $requests = [];

    /**
     * @return RequestStack
     */
    private static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new RequestStack();
        }

        return self::$instance;
    }

    /**
     * @return Request
     */
    public static function getCurrentRequest(): Request
    {
        return end(self::getInstance()->requests);
    }

    /**
     * @param Request $request
     */
    public static function push(Request $request)
    {
        self::getInstance()->requests[] = $request;
    }

    /**
     * @return Request|null
     */
    public static function pop()
    {
        if (!self::getInstance()->requests) {
            return null;
        }

        return array_pop(self::getInstance()->requests);
    }
}