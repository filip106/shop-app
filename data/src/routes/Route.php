<?php

namespace src\routes;


class Route
{

    /** @var string */
    private $method;
    /** @var string */
    private $pattern;
    /** @var string */
    private $controller;
    /** @var string */
    private $action;
    /** @var array */
    private $middleware = [];

    /**
     * Route constructor.
     *
     * @param string $method
     * @param string $pattern
     * @param string $controller
     * @param string $action
     */
    public function __construct(string $method, string $pattern, string $controller, string $action)
    {
        $this->method = $method;
        $this->pattern = $pattern;
        $this->controller = $controller;
        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param $method
     * @param $routeUrl
     *
     * @return bool
     */
    public function matches($method, $routeUrl)
    {
        if (!preg_match('/^' . $this->method . '$/', $method)) {
            return false;
        }

        return !!preg_match($this->pattern, $routeUrl);
    }

    /**
     * @return array
     */
    public function getMiddleware(): array
    {
        return $this->middleware;
    }

    /**
     * @param array $middleware
     *
     * @return Route
     */
    public function middleware(array $middleware): Route
    {
        $this->middleware = $middleware;

        return $this;
    }
}