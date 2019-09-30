<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 01-Sep-19
 * Time: 6:08 PM
 */

namespace src\routes;

use src\Authorization\Request;
use src\Authorization\RequestStack;
use src\Exception\NoRouteFoundException;

/**
 * Class Router
 * @package src\routes
 */
class Router
{
    /** @var array */
    protected static $getRoutes = [];
    /** @var array */
    protected static $postRoutes = [];
    /** @var array */
    protected static $deleteRoutes = [];
    /** @var array */
    protected static $putRoutes = [];
    /** @var array */
    protected static $patchRoutes = [];

    /**
     * @throws NoRouteFoundException
     *
     * @return callable
     */
    public static function matchRoute()
    {
        $routeUrl = RequestStack::getCurrentRequest()->getUri();
        $method = RequestStack::getCurrentRequest()->getMethod();

        switch ($method) {
            case Request::METHOD_GET:
                if (array_key_exists($routeUrl, self::$getRoutes)) {
                    return self::$getRoutes[$routeUrl];
                }

                break;
            case Request::METHOD_POST:
                if (array_key_exists($routeUrl, self::$postRoutes)) {
                    return self::$postRoutes[$routeUrl];
                }

                break;
            case Request::METHOD_DELETE:
                if (array_key_exists($routeUrl, self::$deleteRoutes)) {
                    return self::$deleteRoutes[$routeUrl];
                }

                break;
            case Request::METHOD_PUT:
                if (array_key_exists($routeUrl, self::$putRoutes)) {
                    return self::$putRoutes[$routeUrl];
                }

                break;
            case Request::METHOD_PATCH:
                if (array_key_exists($routeUrl, self::$patchRoutes)) {
                    return self::$patchRoutes[$routeUrl];
                }

                break;

        }

        throw new NoRouteFoundException();
    }

    /**
     * @param string $routeUrl
     * @param callable $callBack
     */
    public static function any($routeUrl, $callBack)
    {
        self::$getRoutes[$routeUrl] = $callBack;
        self::$postRoutes[$routeUrl] = $callBack;
        self::$deleteRoutes[$routeUrl] = $callBack;
        self::$putRoutes[$routeUrl] = $callBack;
        self::$patchRoutes[$routeUrl] = $callBack;
    }

    public static function get($routeUrl, $callBack)
    {
        self::$getRoutes[$routeUrl] = $callBack;
    }

    public static function post($routeUrl, $callBack)
    {
        self::$postRoutes[$routeUrl] = $callBack;
    }

    public static function delete($routeUrl, $callBack)
    {
        self::$deleteRoutes[$routeUrl] = $callBack;
    }

    public static function put($routeUrl, $callBack)
    {
        self::$putRoutes[$routeUrl] = $callBack;
    }

    public static function patch($routeUrl, $callBack)
    {
        self::$patchRoutes[$routeUrl] = $callBack;
    }
}