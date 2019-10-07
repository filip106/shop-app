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
use src\Authorization\Response;
use src\Controller\BaseController;
use src\Exception\NoRouteFoundException;

/**
 * Class Router
 * @package src\routes
 */
class Router
{
    /** @var string */
    private $controller;
    /** @var string*/
    private $method;

    /**
     * Router constructor.
     *
     * @param string $controller
     * @param string $method
     */
    public function __construct($controller, $method)
    {
        $this->controller = $controller;
        $this->method = $method;
    }

    /**
     * @return Router
     */
    public static function generateNotFoundRoute()
    {
        return new self(BaseController::class, 'notFound');
    }

    /**
     * @return Response
     */
    public function handle(): Response
    {
        /** @var BaseController $instance */
        $instance = new $this->controller;

        return $instance->{$this->method}();
    }

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
     * @return Router
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
     * @param string $controller
     * @param string $method
     */
    public static function any($routeUrl, $controller, $method)
    {
        self::$getRoutes[$routeUrl] = new Router($controller, $method);
        self::$postRoutes[$routeUrl] = new Router($controller, $method);
        self::$deleteRoutes[$routeUrl] = new Router($controller, $method);
        self::$putRoutes[$routeUrl] = new Router($controller, $method);
        self::$patchRoutes[$routeUrl] = new Router($controller, $method);
    }

    public static function get($routeUrl, $controller, $method)
    {
        self::$getRoutes[$routeUrl] = new Router($controller, $method);
    }

    public static function post($routeUrl, $controller, $method)
    {
        self::$postRoutes[$routeUrl] = new Router($controller, $method);
    }

    public static function delete($routeUrl, $controller, $method)
    {
        self::$deleteRoutes[$routeUrl] = new Router($controller, $method);
    }

    public static function put($routeUrl, $controller, $method)
    {
        self::$putRoutes[$routeUrl] = new Router($controller, $method);
    }

    public static function patch($routeUrl, $controller, $method)
    {
        self::$patchRoutes[$routeUrl] = new Router($controller, $method);
    }
}