<?php

namespace src\routes;

use ReflectionClass;
use src\Authorization\RequestStack;
use src\Authorization\Response;
use src\Controller\BaseController;
use src\Exception\NoRouteFoundException;
use src\routes\AutoWire\ControllerAutoWire;

/**
 * Class Router
 * @package src\routes
 */
class Router
{
    /** @var Router */
    private static $instance;
    /** @var ControllerAutoWire */
    private $autoWire;

    public function __construct()
    {
        $this->autoWire = ControllerAutoWire::getInstance();
    }

    /**
     * @return Router
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new Router();
        }

        return self::$instance;
    }

    /**
     * @return Route
     */
    public function generateNotFoundRoute()
    {
        return new Route('GET', '', BaseController::class, 'notFound');
    }

    /**
     * @param Route $route
     *
     * @return Response
     * @throws \ReflectionException
     */
    public function handle(Route $route): Response
    {
        /** @var BaseController $instance */
        $controller = $route->getController();

        $controllerClass = new ReflectionClass($controller);
        $controllerClassInstance = $controllerClass->newInstance();

        $method = $controllerClass->getMethod($route->getAction());

        $arguments = $this->autoWire->getArgumentsForMethod($method);

        return $method->invoke($controllerClassInstance, ...$arguments);
    }

    /**
     * @throws NoRouteFoundException
     *
     * @return Route
     */
    public function matchRoute()
    {
        $routeUrl = RequestStack::getCurrentRequest()->getUri();
        $method = RequestStack::getCurrentRequest()->getMethod();

        /** @var Route $route */
        foreach (self::$routes as $route) {
            if ($route->matches($method, $routeUrl)) {
                return $route;
            }
        }

        throw new NoRouteFoundException();
    }

    /** @var array */
    protected static $routes = [];

    /**
     * @param string $routeUrl
     * @param string $controller
     * @param string $action
     */
    public static function any($routeUrl, $controller, $action)
    {
        self::$routes[] = new Route('GET|POST|PUT|PATCH|DELETE', $routeUrl, $controller, $action);
    }

    public static function get($routeUrl, $controller, $action)
    {
        self::$routes[] = new Route('GET', $routeUrl, $controller, $action);
    }

    public static function post($routeUrl, $controller, $action)
    {
        self::$routes[] = new Route('POST', $routeUrl, $controller, $action);
    }

    public static function delete($routeUrl, $controller, $action)
    {
        self::$routes[] = new Route('DELETE', $routeUrl, $controller, $action);
    }

    public static function put($routeUrl, $controller, $action)
    {
        self::$routes[] = new Route('PUT', $routeUrl, $controller, $action);
    }

    public static function patch($routeUrl, $controller, $action)
    {
        self::$routes[] = new Route('PATCH', $routeUrl, $controller, $action);
    }
}