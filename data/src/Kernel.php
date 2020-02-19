<?php

namespace src;

use src\Authorization\Request;
use src\Authorization\RequestStack;
use src\Authorization\Response;
use src\Exception\NoRouteFoundException;
use src\routes\Router;

class Kernel
{
    /** @var string */
    private $environment;

    /** @var string */
    private $projectSrcDir;

    /**
     * Kernel constructor.
     *
     * @param string $environment
     */
    public function __construct($environment)
    {
        $this->environment = $environment;
        $this->projectSrcDir = __DIR__ . '/../';
        define('PROJECT_SRC_DIR', $this->projectSrcDir);
    }

    /**
     * @noinspection PhpDocMissingThrowsInspection
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \ReflectionException
     */
    public function handle(Request $request): Response
    {
        RequestStack::push($request);

        try {
            $route = Router::getInstance()->matchRoute();
        } catch (NoRouteFoundException $e) {
            $route = Router::getInstance()->generateNotFoundRoute();
        }

        try {
            return Router::getInstance()->handle($route);
        } catch (Exception\RedirectException $e) {
            Router::getInstance()->redirect($e->getRedirectRoute());
        }
    }

}