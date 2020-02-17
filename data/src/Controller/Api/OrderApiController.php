<?php

namespace src\Controller\Api;


use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use src\Authorization\Request;
use src\Controller\BaseController;
use src\Manager\OrderManager;
use src\Manager\ProductManager;

class OrderApiController extends BaseController
{
    /**
     * @param Request $request
     * @param OrderManager $orderManager
     * @param ProductManager $productManager
     *
     * @return \src\Authorization\Response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addProduct(Request $request, OrderManager $orderManager, ProductManager $productManager)
    {
        $orderData = $request->getJsonData();

        $order = $orderManager->addProduct($productManager->getReference($orderData['product']['id']), $orderData['quantity']);

        return $this->json(['id' => $order->getId()]);
    }

    /**
     * @param Request $request
     * @param OrderManager $orderManager
     * @param ProductManager $productManager
     *
     * @return \src\Authorization\Response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function removeProduct(Request $request, OrderManager $orderManager, ProductManager $productManager)
    {
        $orderData = $request->getJsonData();

        $order = $orderManager->removeProduct($productManager->getReference($orderData['product']['id']));

        return $this->json(['id' => $order->getId()]);
    }

    /**
     * @param Request $request
     * @param OrderManager $orderManager
     *
     * @return \src\Authorization\Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function finishOrder(Request $request, OrderManager $orderManager)
    {
        $orderData = $request->getJsonData();
        $orderManager->finishOrder($orderData['email']);

        return $this->json([])->setStatusCode(204);
    }
}