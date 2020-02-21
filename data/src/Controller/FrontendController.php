<?php

namespace src\Controller;

use src\Authorization\Request;
use src\Authorization\Response;
use src\Exception\NoRouteFoundException;
use src\Manager\CategoryManager;
use src\Manager\ProductManager;
use src\Manager\UserManager;
use src\Service\SecurityService;

class FrontendController extends BaseController
{
    /**
     * @param Request $request
     * @param ProductManager $manager
     *
     * @return Response
     */
    public function index(Request $request, ProductManager $manager)
    {
        return $this->render('index', ['newestProducts' => $manager->getNewestProducts(8)]);
    }

    /**
     * @return Response
     */
    public function about()
    {
        return $this->render('about');
    }

    /**
     * @param UserManager $userManager
     *
     * @return Response
     */
    public function profile(UserManager $userManager)
    {
        $userId = SecurityService::getInstance()->getAuth()->getUserId();

        return $this->render('user-profile', ['user' => $userManager->findOneById($userId)]);
    }

    /**
     * @return Response
     */
    public function contact()
    {
        return $this->render('contact');
    }

    /**
     * @return Response
     */
    public function cart()
    {
        return $this->render('cart');
    }

    /**
     * @param Request $request
     * @param ProductManager $productManager
     *
     * @return Response
     *
     * @throws NoRouteFoundException
     */
    public function productDetails(Request $request, ProductManager $productManager)
    {
        $productIdentifier = substr($request->getUri(), strrpos($request->getUri(), '/') + 1);

        if (is_numeric($productIdentifier)) {
            $product = $productManager->findOne($productIdentifier);
        } else {
            $product = $productManager->findOneBySlug(urldecode($productIdentifier));
        }

        if (null === $product) {
            throw new NoRouteFoundException();
        }

        return $this->render('product-details', ['product' => $product]);
    }

    /**
     * @param Request $request
     * @param CategoryManager $categoryManager
     *
     * @return Response
     * @throws NoRouteFoundException
     */
    public function categoryDetails(Request $request, CategoryManager $categoryManager, ProductManager $productManager)
    {
        $categoryIdentifier = substr($request->getUri(), strrpos($request->getUri(), '/') + 1);

        if (is_numeric($categoryIdentifier)) {
            $category = $categoryManager->findOne($categoryIdentifier);
        } else {
            $category = $categoryManager->findOneBySlug(urldecode($categoryIdentifier));
        }

        if (null === $category) {
            throw new NoRouteFoundException();
        }

        return $this->render('category-details', ['category' => $category, 'products' => $productManager->findAllForCategory($category)]);
    }
}