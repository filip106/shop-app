<?php

namespace src\Model;

/**
 * Class Product
 * @package src\Model
 */
class Product extends BasicEntity
{
    /** @var int|null */
    protected $id;

    /** @var string */
    protected $name;

    /** @var string */
    protected $shortDescription;

    /** @var string */
    protected $description;

    /** @var float */
    protected $price;

    /** @var string */
    protected $code;

    /** @var string */
    protected $baseImage;

    /** @var array */
    protected $images;

    /** @var \DateTime */
    protected $createdAt;

    /**
     * Product constructor.
     */
    public function __construct()
    {
        $this->images = [];
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
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @param array $images
     *
     * @return Product
     */
    public function setImages(array $images): Product
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
}