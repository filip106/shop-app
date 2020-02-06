<?php

namespace src\Manager;

use Doctrine\ORM\Mapping\ClassMetadata;
use src\Database\DbManager;
use src\Model\Product;
use src\Repository\ProductRepository;

/**
 * Class ProductManager
 * @package src\Manager
 */
class ProductManager
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
     * @param int $limit
     *
     * @return array
     *
     * @throws \Exception
     */
    public function getNewestProducts(int $limit = 5)
    {
        return $this->productRepository->getNewestProducts($limit);
    }
}