<?php

namespace src\routes\Middleware;

use src\Controller\BaseController;
use src\Exception\RedirectException;
use src\Manager\OrderManager;
use src\Service\SecurityService;

class ControllerMiddleware
{

    /**
     * @param array $middleware
     * @param BaseController $controllerInstance
     *
     * @throws RedirectException
     */
    public function handleMiddleware(array $middleware, BaseController $controllerInstance)
    {
        if (0 === count($middleware)) {
            return;
        }

        foreach ($middleware as $mw => $value) {
            switch ($mw) {
                case 'order':
                    $controllerInstance->setDefaultParams(['order' => OrderManager::getInstance()->getLastOrderForUser()]);
                    break;
                case 'auth':
                    if (false === $value && SecurityService::getInstance()->getAuth()->isLoggedIn()) {
                        throw new RedirectException('/');
                    }

                    if (true === $value && !SecurityService::getInstance()->getAuth()->isLoggedIn()) {
                        throw new RedirectException('login');
                    }

                    if (is_array($value)) {
                        if (!SecurityService::getInstance()->getAuth()->hasAnyRole(...$value)) {
                            throw new RedirectException('/');
                        }
                    }
                    break;
                default:
                    throw new \InvalidArgumentException(sprintf('Invalid argument provided for middleware %s!', $mw));
            }

        }
    }
}