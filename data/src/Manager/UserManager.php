<?php

namespace src\Manager;

use src\Database\DbManager;
use src\Model\User;
use src\Repository\UserRepository;

class UserManager extends BasicManager
{
    /** @var UserRepository */
    private $userRepository;

    /** @var ProductManager */
    private static $instance;

    /**
     * @return UserManager
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new UserManager();
        }

        return self::$instance;
    }

    /**
     * UserManager constructor.
     */
    private function __construct()
    {
        $this->userRepository = DbManager::getInstance()->em->getRepository(User::class);
    }

    /**
     * @param int $id
     *
     * @return User|object|null
     */
    public function findOneById(int $id)
    {
        return $this->userRepository->findOneBy(['id' => $id]);
    }
}