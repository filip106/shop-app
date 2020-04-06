<?php
/**
 * Created by PhpStorm.
 * User: Aleksandra
 * Date: 26-Sep-19
 * Time: 10:57 PM
 */

namespace src\Controller;

use src\Authorization\Response;

class AuthController extends BaseController
{
    /**
     * @return Response
     */
    public function login()
    {
        return $this->render('login');
    }

    /**
     * @return Response
     */
    public function register()
    {
        return $this->render('register');
    }
}