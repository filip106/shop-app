<?php

namespace src\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\Persistence\Proxy;
use src\Manager\ImageManager;

/**
 * Class Image
 * @package src\Model
 * @ORM\Entity()
 * @ORM\Table("sa_images")
 * @HasLifecycleCallbacks
 */
class Image extends BasicEntity
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
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var string|null
     */
    protected $base64;

    /**
     * @var Product|Proxy|null
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="images")
     */
    protected $product;

    /**
     * @PrePersist
     */
    public function saveToFileOnPrePersist()
    {
        ImageManager::getInstance()->saveImageToFile($this);
    }

    public function getRealPath()
    {
        return sprintf('%s/%s', ImageManager::PRODUCT_IMAGE_DIR, $this->name);
    }

    /**
     * @return string
     */
    public function getWebPath()
    {
        return sprintf('%s/%s', ImageManager::PRODUCT_IMAGE_WEB_ROOT, $this->name);
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
     * @return Image
     */
    public function setId(?int $id): Image
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Image
     */
    public function setName(string $name): Image
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBase64(): ?string
    {
        return $this->base64;
    }

    /**
     * @param string|null $base64
     *
     * @return Image
     */
    public function setBase64(?string $base64): Image
    {
        $this->base64 = $base64;

        return $this;
    }

    /**
     * @return Proxy|Product|null
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Proxy|Product|null $product
     *
     * @return Image
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }
}