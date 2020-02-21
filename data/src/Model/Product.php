<?php

namespace src\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Persistence\Event\LifecycleEventArgs;

/**
 * Class Product
 * @package src\Model
 * @ORM\Entity(repositoryClass="src\Repository\ProductRepository")
 * @ORM\Table("sa_products")
 * @HasLifecycleCallbacks
 */
class Product extends BasicEntity
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
     * @var string
     *
     * @ORM\Column(name="short_description", type="string")
     */
    protected $shortDescription;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    protected $price;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    protected $code;

    /**
     * @var string
     *
     * @ORM\Column(name="base_image", type="string")
     */
    protected $baseImage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    protected $createdAt;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="ProductCategory", mappedBy="product", cascade={"persist"})
     */
    protected $categories;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Image", mappedBy="product", cascade={"persist"})
     */
    protected $images;

    /**
     * Product constructor.
     */
    public function __construct()
    {
        $this->images = new ArrayCollection();
        try {
            $this->createdAt = new \DateTime();
        } catch (\Exception $e) {
        }
    }

    /**
     * @ORM\PostPersist()
     */
    public function saveToFileOnPrePersist(LifecycleEventArgs $args)
    {
        if ($this->images->count() > 0) {
            $this->setBaseImage($this->images->first()->getWebPath());
        }

        $args->getObjectManager()->persist($this);
        $args->getObjectManager()->flush();
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
     * @return Product
     */
    public function setId(?int $id): Product
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
     * @return Product
     */
    public function setName(string $name): Product
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     *
     * @return Product
     */
    public function setShortDescription(string $shortDescription): Product
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Product
     */
    public function setDescription(string $description): Product
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     *
     * @return Product
     */
    public function setPrice(float $price): Product
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return Product
     */
    public function setCode(string $code): Product
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getBaseImage(): string
    {
        return $this->baseImage;
    }

    /**
     * @param string $baseImage
     *
     * @return Product
     */
    public function setBaseImage(string $baseImage): Product
    {
        $this->baseImage = $baseImage;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param Collection $images
     *
     * @return Product
     */
    public function setImages($images): Product
    {
        $this->images = $images;

        return $this;
    }

    /**
     * @param $image
     *
     * @return Product
     */
    public function addImage($image): Product
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return Product
     */
    public function setCreatedAt(\DateTime $createdAt): Product
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * @param Collection $categories
     *
     * @return Product
     */
    public function setCategories(Collection $categories): Product
    {
        $this->categories = $categories;

        return $this;
    }
}