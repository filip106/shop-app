<?php

namespace src\Manager;

use src\Database\DbManager;
use src\Model\Category;
use src\Repository\CategoryRepository;

class CategoryManager extends BasicManager
{
    /** @var CategoryRepository */
    private $categoryRepository;

    /** @var ProductManager */
    private static $instance;

    /**
     * @return CategoryManager
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new CategoryManager();
        }

        return self::$instance;
    }

    /**
     * CategoryManager constructor.
     */
    private function __construct()
    {
        $this->categoryRepository = DbManager::getInstance()->em->getRepository(Category::class);
    }

    /**
     * @return Category[]|array|object[]
     */
    public function findAll()
    {
        return $this->categoryRepository->findAll();
    }

    /**
     * @param $id
     *
     * @return Category|object|null
     */
    public function findOne($id)
    {
        return $this->categoryRepository->findOneBy(['id' => $id]);

    }

    /**
     * @param string $slug
     *
     * @return Category|object|null
     */
    public function findOneBySlug(string $slug)
    {
        return $this->categoryRepository->findOneBy(['name' => $slug]);
    }
}