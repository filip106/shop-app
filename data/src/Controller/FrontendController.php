<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 06-Oct-19
 * Time: 1:52 PM
 */

namespace src\Controller;

use src\Authorization\Request;
use src\Authorization\Response;
use src\Exception\NoRouteFoundException;
use src\Manager\ProductManager;

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
        return $this->render('index', ['method' => $request->getMethod()]);
    }

    /**
     * @return Response
     */
    public function about()
    {
        return $this->render('about');
    }

    /**
     * @return Response
     */
    public function profile()
    {
        return $this->render('user-profile');
    }

    /**
     * @return Response
     */
    public function contact()
    {
        return $this->render('contact');
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
}