<?php

namespace src\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Image
 * @package src\Model
 * @ORM\Entity()
 * @ORM\Table("sa_images")
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
}