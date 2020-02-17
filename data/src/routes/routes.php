<?php

use src\Controller\AdminController;
use src\Controller\Api\OrderApiController;
use src\Controller\Api\ProductApiController;
use src\Controller\AuthController;
use src\Controller\FrontendController;
use src\routes\Router;

Router::any('|^/$|', FrontendController::class, 'index');
Router::any('|^/about$|', FrontendController::class, 'about');
Router::any('|^/profile$|', FrontendController::class, 'profile');
Router::any('|^/contact$|', FrontendController::class, 'contact');
Router::any('|^/cart|', FrontendController::class, 'cart');

Router::any('|^/login$|', AuthController::class, 'login');
Router::any('|^/register$|', AuthController::class, 'register');

Router::any('|^/product/[A-Za-z0-9]+|', FrontendController::class, 'productDetails');

/** Admin section */
Router::any('|^/admin$|', AdminController::class, 'dashboard');
Router::any('|^/admin/product/list$|', AdminController::class, 'productList');
Router::any('|^/admin/product/create$|', AdminController::class, 'productCreate');


/** ------------------------------------- API ROUTES ------------------------------------- */
Router::get('|^/api/product|', ProductApiController::class, 'list');
Router::post('|^/api/product|', ProductApiController::class, 'create');

Router::post('|^/api/order/add-product|', OrderApiController::class, 'addProduct');
Router::post('|^/api/order/remove-product|', OrderApiController::class, 'removeProduct');
Router::post('|^/api/order/finish-order|', OrderApiController::class, 'finishOrder');
