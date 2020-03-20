<?php


namespace src\Controller\Api;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use src\Authorization\Request;
use src\Controller\BaseController;
use src\Manager\CategoryManager;
use src\Model\Category;
use src\Validator\CategoryValidator;

class CategoryApiController extends BaseController
{

    public function list(CategoryManager $categoryManager, Request $request)
    {
        $page = array_key_exists('page', $request->all()) ? $request->all()['page'] : 1;
        $offset = array_key_exists('rows', $request->all()) ? $request->all()['rows'] : 5;

        return $this->json($categoryManager->getCategoriesAsArray($page, $offset));
    }

    public function create(Request $request, CategoryManager $categoryManager, EntityManager $em, CategoryValidator $validator)
    {
        $categoryData = $request->getJsonData();
        if (true !== $errors = $validator->validate($categoryData)) {
            return $this->json(['errors' => $errors]);
        }

        $category = (new Category())
            ->setName($categoryData['name'])
            ->setDescription($categoryData['description']);

        /** Save product */
        $category = $categoryManager->saveCategory($category);

        return $this->json(['id' => $category ? $category->getId() : -1]);
    }

    public function delete(Request $request, CategoryManager $manager, EntityManager $em)
    {
        $categoryId = substr($request->getUri(), strrpos($request->getUri(), '/') + 1);

        $entity = $manager->findOne($categoryId);

        if (null === $entity) {
            return $this->json([
                'code' => 400
            ]);
        }

        try {
            $em->remove($entity);
            $em->flush();
        } catch (OptimisticLockException|ORMException $e) {
            return $this->json([
                'code' => 404
            ]);
        }

        return $this->json([
            'code' => 200
        ]);
    }
}