<?php

namespace src\Manager;

use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
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
     * @param int $page
     * @param int $offset
     *
     * @return mixed
     */
    public function getCategoriesAsArray($page = 1, $offset = 10)
    {
        $totalItems = $this->categoryRepository->getCategoriesAsArrayCount();

        return [
            'rows' => $this->categoryRepository->getCategoriesAsArray($page, $offset),
            'page' => $page,
            'records' => $totalItems,
            'total' => ceil($totalItems/$offset)
        ];
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

    /**
     * @param Category $category
     *
     * @return Category|null
     */
    public function saveCategory(Category $category)
    {
        try {
            return $this->categoryRepository->save($category);
        } catch (OptimisticLockException|ORMException $e) {
            return null;
        }
    }
}