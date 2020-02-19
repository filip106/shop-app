<?php

namespace src\Model;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package src\Model
 * @ORM\Entity()
 * @ORM\Table("sa_users")
 */
class User extends BasicEntity implements UserInterface
{
    /**
     * @var int|null
     *
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true, nullable=false)
     */
    protected $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false)
     */
    protected $password;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    protected $email;

    /**
     * @var Collection
     * @ORM\OneToMany(targetEntity="Order", mappedBy="user")
     */
    protected $orders;

    /**
     * @var bool
     * @ORM\Column(type="integer", nullable=false, options={"default": "0"})
     */
    protected $status = 0;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=false, options={"default": "0"})
     */
    protected $verified = false;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=false, options={"default": "1"})
     */
    protected $resettable = true;

    /**
     * @var integer
     * @ORM\Column(name="roles_mask", type="integer", nullable=false, options={"default": "0"})
     */
    protected $rolesMask;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=false)
     */
    protected $registered;

    /**
     * @var integer
     * @ORM\Column(name="last_login", type="integer", nullable=true)
     */
    protected $lastLogin;

    /**
     * @var integer
     * @ORM\Column(name="force_logout", type="integer", nullable=false, options={"default": "0"})
     */
    protected $forceLogout;

    /**
     * User constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     *
     * @return User
     */
    public function setId($id): User
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username): User
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email): User
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }
}