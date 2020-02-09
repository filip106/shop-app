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
//        echo '<pre>';
//        var_dump($_REQUEST);
//        var_dump($_POST);
//        var_dump(json_decode(file_get_contents('php://input')));
//        echo '</pre>';
//        die;

        $productData = json_decode(file_get_contents('php://input'), true);

        $product = (new Product())->setName($productData['name'])->setPrice($productData['price'])->setCode($productData['code'])
            ->setShortDescription($productData['short_description'])->setDescription($productData['description'])->setCreatedAt(new \DateTime())->setBaseImage('n/a');

        $product = $productManager->saveProduct($product);

        return $this->json(['id' => $product ? $product->getId() : -1]);
    }
}