<?php

namespace src\routes\AutoWire;

use Doctrine\ORM\EntityManager;
use src\Authorization\Request;
use src\Authorization\RequestStack;
use src\Database\DbManager;
use src\Manager\BasicManager;
use src\Manager\OrderManager;
use src\Model\Order;
use src\Validator\BaseValidator;

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

            if ($parameterClass->isSubclassOf(BaseValidator::class)) {
                $arguments[] = $parameterClass->newInstance();
                continue;
            }

            if ($parameterClass->getName() === EntityManager::class) {
                $arguments[] = DbManager::getInstance()->em;
                continue;
            }

            throw new \InvalidArgumentException(sprintf('Invalid argument provided for parameter %s!', $parameter->getName()));
        }

        return $arguments;
    }
}