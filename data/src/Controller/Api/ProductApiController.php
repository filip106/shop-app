<?php

namespace src\Controller\Api;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use src\Authorization\Request;
use src\Controller\BaseController;
use src\Manager\ProductManager;
use src\Model\Category;
use src\Model\Image;
use src\Model\Product;
use src\Model\ProductCategory;

class ProductApiController extends BaseController
{

    public function list(ProductManager $productManager)
    {
        return $this->json($productManager->getProductsAsArray());
    }

    public function create(Request $request, ProductManager $productManager, EntityManager $em)
    {
        $productData = $request->getJsonData();

        $product = (new Product())->setName($productData['name'])->setPrice($productData['price'])
            ->setCode($productData['code'])->setShortDescription($productData['short_description'])
            ->setDescription($productData['description'])->setCreatedAt(new \DateTime())
            ->setBaseImage('n/a');

        /** Set images */
        $images = new ArrayCollection(array_map(function ($el) use ($product) {
            return (new Image())->setProduct($product)->setName($el['name'])->setBase64($el['base64']);
        }, $productData['images']));
        $product->setImages($images);

        /** Set categories */
        $productCategories = new ArrayCollection(array_map(function ($el) use ($em, $product) {
            return (new ProductCategory())->setProduct($product)->setCategory($em->getReference(Category::class, $el['id']));
        }, $productData['categories']));
        $product->setCategories($productCategories);

        /** Save product */
        $product = $productManager->saveProduct($product);

        return $this->json(['id' => $product ? $product->getId() : -1]);
    }
}