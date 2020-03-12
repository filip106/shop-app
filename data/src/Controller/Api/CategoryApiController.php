<?php


namespace src\Controller\Api;


use Doctrine\ORM\EntityManager;
use src\Authorization\Request;
use src\Controller\BaseController;
use src\Manager\CategoryManager;
use src\Model\Category;

class CategoryApiController extends BaseController
{

    public function list(CategoryManager $categoryManager)
    {
        return $this->json($categoryManager->getCategoriesAsArray());
    }

    public function create(Request $request, CategoryManager $categoryManager, EntityManager $em)
    {
        $categoryData = $request->getJsonData();

        $category = (new Category())
            ->setName($categoryData['name'])
            ->setDescription($categoryData['description']);

        /** Save product */
        $category = $categoryManager->saveCategory($category);

        return $this->json(['id' => $category ? $category->getId() : -1]);
    }
}