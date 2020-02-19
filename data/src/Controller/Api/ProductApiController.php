<?php

namespace src\Controller\Api;


use src\Authorization\Request;
use src\Controller\BaseController;
use src\Manager\ProductManager;
use src\Model\Product;

class ProductApiController extends BaseController
{

    public function list(ProductManager $productManager)
    {
        return $this->json($productManager->getProductsAsArray());
    }

    public function create(Request $request, ProductManager $productManager)
    {
        $productData = $request->getJsonData();

        $product = (new Product())->setName($productData['name'])->setPrice($productData['price'])->setCode($productData['code'])
            ->setShortDescription($productData['short_description'])->setDescription($productData['description'])->setCreatedAt(new \DateTime())->setBaseImage('n/a');

        $product = $productManager->saveProduct($product);

        return $this->json(['id' => $product ? $product->getId() : -1]);
    }
}