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
use src\Manager\ProductManager;

class FrontendController extends BaseController
{
    /**
     * @param Request $request
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
}