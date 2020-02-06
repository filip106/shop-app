<?php

namespace src\Controller;

use src\Authorization\Response;

class AdminController extends BaseController
{
    /**
     * @return Response
     */
    public function dashboard()
    {
        return $this->render('admin/dashboard');
    }

    /**
     * @return Response
     */
    public function productList()
    {
        return $this->render('admin/product/list');
    }

    /**
     * @return Response
     */
    public function productCreate()
    {
        return $this->render('admin/product/create');
    }
}