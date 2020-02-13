<?php

namespace src\Model;

use Doctrine\ORM\Mapping as ORM;


/**
 * Class OrderItem
 * @package src\Model
 *
 * @ORM\Entity()
 * @ORM\Table("sa_order_items")
 */
class OrderItem
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
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    protected $product;

    /**
     * @var Order
     *
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="orderItems")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     */
    protected $order;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer", options={"default": 1})
     */
    protected $quantity = 1;

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
     * @return OrderItem
     */
    public function setId(?int $id): OrderItem
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     *
     * @return OrderItem
     */
    public function setProduct(Product $product): OrderItem
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @param Order $order
     *
     * @return OrderItem
     */
    public function setOrder(?Order $order): OrderItem
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return OrderItem
     */
    public function setQuantity(int $quantity): OrderItem
    {
        $this->quantity = $quantity;

        return $this;
    }
}