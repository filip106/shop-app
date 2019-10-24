<?php

namespace src\Manager;

use src\Repository\ProductRepository;

/**
 * Class ProductManager
 * @package src\Manager
 */
class ProductManager
{
    /** @var ProductRepository */
    private $productRepository;

    /**
     * ProductManager constructor.
     *
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
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