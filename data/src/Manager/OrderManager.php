<?php

namespace src\Manager;


use Doctrine\Persistence\Proxy;
use http\Exception\InvalidArgumentException;
use src\Database\DbManager;
use src\Model\EnumType\EnumOrderType;
use src\Model\Order;
use src\Model\OrderItem;
use src\Model\Product;
use src\Repository\OrderRepository;
use src\Session\Session;

class OrderManager extends BasicManager
{
    /** @var OrderRepository */
    private $orderRepository;

    /** @var OrderManager */
    private static $instance;

    /** @var Order|null */
    private $order = null;

    /**
     * @return OrderManager
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new OrderManager();
        }

        return self::$instance;
    }

    /**
     * OrderManager constructor.
     */
    private function __construct()
    {
        $this->orderRepository = DbManager::getInstance()->em->getRepository(Order::class);
    }

    /**
     * @param Product|Proxy $product
     * @param int $quantity
     *
     * @return mixed|Order|null
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addProduct($product, $quantity)
    {
        $order = $this->getLastOrderForUser();

        $orderItem = $this->findOrderItem($order, $product);
        $orderItem->setQuantity($orderItem->getQuantity() + $quantity);

        $order->addOrderItem($orderItem);

        $this->orderRepository->saveOrder($order);

        return $order;
    }

    /**
     * @param Product|Proxy $product
     *
     * @return bool|mixed|Order|null
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function removeProduct($product)
    {
        $order = $this->getLastOrderForUser();

        $orderItem = $this->findOrderItem($order, $product);
        if (null === $orderItem->getId()) {
            throw new InvalidArgumentException();
        }

        $order->removeOrderItem($orderItem);

        $this->orderRepository->saveOrder($order);

        return $order;
    }

    /**
     * @param Order $order
     * @param Product|Proxy $product
     *
     * @return OrderItem
     */
    private function findOrderItem($order, $product)
    {
        /** @var OrderItem $orderItem */
        foreach ($order->getOrderItems() as $orderItem) {
            if ($product->getId() === $orderItem->getProduct()->getId()) {
                return $orderItem;
            }
        }

        return (new OrderItem())->setOrder($order)->setProduct($product)->setQuantity(0);
    }

    /**
     * @return mixed|Order|null
     */
    public function getLastOrderForUser()
    {
        if (null === $this->order) {
            $this->order = $this->orderRepository->getLastOrderForUser(Session::getInstance()->sessionId());
            if (null === $this->order || !in_array($this->order->getState(), EnumOrderType::CAN_CONTINUE_STATES)) {
                $this->order = self::createDefaultOrder();
            }
        }

        return $this->order;
    }

    public static function createDefaultOrder()
    {
        return (new Order())->setState(EnumOrderType::STATE_NEW)->setSessionId(Session::getInstance()->sessionId());
    }
}