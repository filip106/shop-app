<?php

namespace src\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\Proxy;

/**
 * Class Order
 * @package src\Model
 *
 * @ORM\Entity(repositoryClass="src\Repository\OrderRepository")
 * @ORM\Table("sa_orders")
 */
class Order
{
    /**
     * @var int|null
     *
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     *
     */
    protected $id;

    /**
     * @var User|null
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orders")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="OrderItem", mappedBy="order", cascade={"persist", "remove"}, orphanRemoval=TRUE)
     */
    protected $orderItems;

    /**
     * @var string
     * @ORM\Column(name="session_id", type="string")
     */
    protected $sessionId;

    /**
     * @var string
     * @ORM\Column(name="state", type="string")
     */
    protected $state;

    /**
     * Order constructor.
     */
    public function __construct()
    {
        $this->orderItems = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     *
     * @return Order
     */
    public function setId(?int $id): Order
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User|Proxy|null $user
     *
     * @return Order
     */
    public function setUser($user): Order
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getOrderItems(): Collection
    {
        return $this->orderItems;
    }

    /**
     * @param Collection $orderItems
     *
     * @return Order
     */
    public function setOrderItems(Collection $orderItems): Order
    {
        $this->orderItems = $orderItems;

        return $this;
    }

    /**
     * @param OrderItem|Proxy $orderItem
     *
     * @return Order
     */
    public function addOrderItem($orderItem)
    {
        $this->orderItems->add($orderItem);

        return $this;
    }

    /**
     * @param OrderItem|Proxy $orderItem
     *
     * @return Order
     */
    public function removeOrderItem($orderItem)
    {
        if ($this->orderItems->contains($orderItem)) {
            $this->orderItems->remove($this->orderItems->indexOf($orderItem));
            $orderItem->setOrder(null);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    /**
     * @param string $sessionId
     *
     * @return Order
     */
    public function setSessionId(string $sessionId): Order
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     *
     * @return Order
     */
    public function setState(string $state): Order
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return float|int
     */
    public function getOrderTotal()
    {
        return array_sum($this->orderItems->map(function ($oi) {
            /** @var OrderItem $oi */

            return $oi->getProduct()->getPrice() * $oi->getQuantity();
        })->toArray());
    }
}