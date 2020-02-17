<?php

namespace src\Manager;

use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use src\Database\DbManager;
use src\Model\Product;
use src\Repository\ProductRepository;

/**
 * Class ProductManager
 * @package src\Manager
 */
class ProductManager extends BasicManager
{
    /** @var ProductRepository */
    private $productRepository;

    /** @var ProductManager */
    private static $instance;

    /**
     * @return ProductManager
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new ProductManager();
        }

        return self::$instance;
    }

    /**
     * ProductManager constructor.
     */
    private function __construct()
    {
        $this->productRepository = DbManager::getInstance()->em->getRepository(Product::class);
    }

    /**
     * @param int $id
     *
     * @return bool|\Doctrine\Common\Proxy\Proxy|object|null
     */
    public function getReference($id)
    {
        return $this->productRepository->getReference($id);
    }

    /**
     * @param int $limit
     *
     * @return array
     */
    public function getNewestProducts(int $limit = 5)
    {
        try {
            return $this->productRepository->getNewestProducts($limit);
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * @param int $page
     * @param int $offset
     *
     * @return mixed
     */
    public function getProductsAsArray($page = 1, $offset = 10)
    {
        return $this->productRepository->getProductsAsArray($page, $offset);
    }

    /**
     * @param Product $product
     *
     * @return Product
     */
    public function saveProduct(Product $product)
    {
        try {
            return $this->productRepository->save($product);
        } catch (OptimisticLockException|ORMException $e) {
            return null;
        }
    }

    /**
     * @param int $id
     *
     * @return Product|object
     */
    public function findOne(int $id)
    {
        return $this->productRepository->find($id);
    }

    /**
     * @param string $slug
     *
     * @return Product|object|null
     */
    public function findOneBySlug(string $slug)
    {
        return $this->productRepository->findOneBy(['name' => $slug]);
    }
}