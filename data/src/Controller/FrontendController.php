<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 06-Oct-19
 * Time: 1:52 PM
 */

namespace src\Controller;

use src\Authorization\Response;

class FrontendController extends BaseController
{
    /**
     * @return Response
     */
    public function index()
    {
        return $this->render('index.php');
    }

    /**
     * @return Response
     */
    public function about()
    {
        return $this->render('about.php');
    }

    /**
     * @return Response
     */
    public function profile()
    {
        return $this->render('user-profile.php');
    }

    /**
     * @return Response
     */
    public function contact()
    {
        return $this->render('contact.php');
    }
}