<?php

namespace src\Manager;


use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\Proxy;
use http\Exception\InvalidArgumentException;
use src\Database\DbManager;
use src\Model\EnumType\EnumOrderType;
use src\Model\Order;
use src\Model\OrderItem;
use src\Model\Product;
use src\Model\User;
use src\Repository\OrderRepository;
use src\Service\MailService;
use src\Service\SecurityService;
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

        if (!$orderItem->getId()) {
            $order->addOrderItem($orderItem);
        }

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
            return $order;
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
            /** TODO return if user is logged in */
            $this->order = $this->orderRepository->getLastOrderForUser(Session::getInstance()->sessionId());
            if (null === $this->order || !in_array($this->order->getState(), EnumOrderType::CAN_CONTINUE_STATES)) {
                $this->order = self::createDefaultOrder();
            }
        }

        return $this->order;
    }

    /**
     * @return Order
     */
    public static function createDefaultOrder()
    {
        $user = null;
        if (null !== $userId = SecurityService::getInstance()->getAuth()->getUserId()) {
            try {
                $user = DbManager::getInstance()->em->getReference(User::class, $userId);
            } catch (ORMException $e) {
                $user = null;
            }
        }

        return (new Order())
            ->setState(EnumOrderType::STATE_NEW)
            ->setSessionId(Session::getInstance()->sessionId())
            ->setUser($user);
    }

    /**
     * @param $email
     *
     * @return int
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function finishOrder($email)
    {
        $order = $this->getLastOrderForUser();

        if (null === $order->getId()) {
            return 0;
        }

        $order->setState(EnumOrderType::STATE_PENDING);
        $this->orderRepository->saveOrder($order);

        return MailService::getInstance()->sendMail('Order Created', 'New Order created: ' . $order->getId(), $email);
    }
}