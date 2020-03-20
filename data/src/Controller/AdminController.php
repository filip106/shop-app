<?php

namespace src\Controller;

use src\Authorization\Request;
use src\Authorization\Response;
use src\Manager\CategoryManager;

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
    public function categoryList()
    {
        return $this->render('admin/category/list');
    }

    /**
     * @param CategoryManager $categoryManager
     *
     * @return Response
     */
    public function productCreate(CategoryManager $categoryManager)
    {
        return $this->render('admin/product/create', ['categories' => $categoryManager->findAll()]);
    }

    /**
     * @return Response
     */
    public function categoryCreate()
    {
        return $this->render('admin/category/create');
    }

    public function categoryUpdate(CategoryManager $categoryManager, Request $request)
    {
        return $this->render('admin/category/update', ['category' => $categoryManager->findOne($request->identifier())]);
    }
}