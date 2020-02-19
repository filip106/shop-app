<?php

namespace src\routes\AutoWire;

use src\Authorization\Request;
use src\Authorization\RequestStack;
use src\Manager\BasicManager;
use src\Manager\OrderManager;
use src\Model\Order;

class ControllerAutoWire
{
    /**
     * @param \ReflectionMethod $method
     *
     * @return array
     */
    public function getArgumentsForMethod(\ReflectionMethod $method)
    {
        $arguments = [];

        $parameters = $method->getParameters();
        foreach ($parameters as $parameter) {
            $parameterClass = $parameter->getClass();

            if ($parameterClass->getName() === Request::class) {
                $arguments[] = RequestStack::getCurrentRequest();
                continue;
            }

            if ($parameterClass->getName() === Order::class) {
                $arguments[] = OrderManager::getInstance()->getLastOrderForUser();
                continue;
            }

            if ($parameterClass->isSubclassOf(BasicManager::class)) {
                $managerInstance = $parameterClass->newInstanceWithoutConstructor();

                $arguments[] = $managerInstance::getInstance();
                continue;
            }

            throw new \InvalidArgumentException(sprintf('Invalid argument provided for parameter %s!', $parameter->getName()));
        }

        return $arguments;
    }
}