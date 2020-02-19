<?php

namespace src\routes;

use ReflectionClass;
use src\Authorization\RequestStack;
use src\Authorization\Response;
use src\Controller\BaseController;
use src\Exception\NoRouteFoundException;
use src\Manager\OrderManager;
use src\routes\AutoWire\ControllerAutoWire;
use src\routes\Middleware\ControllerMiddleware;

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
    /** @var ControllerMiddleware */
    private $middleware;

    public function __construct(ControllerAutoWire $autoWire, ControllerMiddleware $middleware)
    {
        $this->autoWire = $autoWire;
        $this->middleware = $middleware;
    }

    /**
     * @return Router
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new Router(new ControllerAutoWire(), new ControllerMiddleware());
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
     * @param string $route
     */
    public function redirect(string $route)
    {
        header("Location: $route");
        die();
    }

    /**
     * @param Route $route
     *
     * @return Response
     * @throws \ReflectionException
     * @throws \src\Exception\RedirectException
     */
    public function handle(Route $route): Response
    {
        $controller = $route->getController();

        $controllerClass = new ReflectionClass($controller);
        /** @var BaseController $controllerClassInstance */
        $controllerClassInstance = $controllerClass->newInstance();
        $this->middleware->handleMiddleware($route->getMiddleware(), $controllerClassInstance);

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
     *
     * @return Route
     */
    public static function any($routeUrl, $controller, $action)
    {
        $route = new Route('GET|POST|PUT|PATCH|DELETE', $routeUrl, $controller, $action);
        self::$routes[] = $route;

        return $route;
    }

    public static function get($routeUrl, $controller, $action)
    {
        $route = new Route('GET', $routeUrl, $controller, $action);
        self::$routes[] = $route;

        return $route;
    }

    public static function post($routeUrl, $controller, $action)
    {
        $route = new Route('POST', $routeUrl, $controller, $action);
        self::$routes[] = $route;

        return $route;
    }

    public static function delete($routeUrl, $controller, $action)
    {
        $route = new Route('DELETE', $routeUrl, $controller, $action);
        self::$routes[] = $route;

        return $route;
    }

    public static function put($routeUrl, $controller, $action)
    {
        $route = new Route('PUT', $routeUrl, $controller, $action);
        self::$routes[] = $route;

        return $route;
    }

    public static function patch($routeUrl, $controller, $action)
    {
        $route = new Route('PATCH', $routeUrl, $controller, $action);
        self::$routes[] = $route;

        return $route;
    }
}