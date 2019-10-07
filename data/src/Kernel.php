<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 30-Sep-19
 * Time: 5:06 PM
 */

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
     * @param Request $request
     *
     * @return Response
     */
    public function handle(Request $request): Response
    {
        RequestStack::push($request);

        try {
            $router = Router::matchRoute();
        } catch (NoRouteFoundException $e) {
            $router = Router::generateNotFoundRoute();
        }

        return $router->handle();
    }

}