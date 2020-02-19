<?php

use Delight\Auth\Role;
use src\Controller\AdminController;
use src\Controller\Api\OrderApiController;
use src\Controller\Api\ProductApiController;
use src\Controller\Api\SecurityController;
use src\Controller\AuthController;
use src\Controller\FrontendController;
use src\routes\Router;

Router::any('|^/$|', FrontendController::class, 'index');
Router::any('|^/about$|', FrontendController::class, 'about');
Router::any('|^/profile$|', FrontendController::class, 'profile')->middleware(['auth' => true]);
Router::any('|^/contact$|', FrontendController::class, 'contact');
Router::any('|^/cart|', FrontendController::class, 'cart');

Router::any('|^/login$|', AuthController::class, 'login')->middleware(['auth' => false]);
Router::any('|^/register$|', AuthController::class, 'register')->middleware(['auth' => true]);

Router::any('|^/product/[A-Za-z0-9]+|', FrontendController::class, 'productDetails');
Router::any('|^/category/[A-Za-z0-9]+|', FrontendController::class, 'categoryDetails');

/** Admin section */
Router::any('|^/admin$|', AdminController::class, 'dashboard')->middleware(['auth' => [Role::ADMIN]]);
Router::any('|^/admin/product/list$|', AdminController::class, 'productList')->middleware(['auth' => [Role::ADMIN]]);
Router::any('|^/admin/product/create$|', AdminController::class, 'productCreate')->middleware(['auth' => [Role::ADMIN]]);


/** ------------------------------------- API ROUTES ------------------------------------- */
Router::get('|^/api/product|', ProductApiController::class, 'list');
Router::post('|^/api/product|', ProductApiController::class, 'create');

Router::post('|^/api/login|', SecurityController::class, 'login');
Router::post('|^/api/logout|', SecurityController::class, 'logout');
Router::post('|^/api/register|', SecurityController::class, 'register');

Router::post('|^/api/order/add-product|', OrderApiController::class, 'addProduct');
Router::post('|^/api/order/remove-product|', OrderApiController::class, 'removeProduct');
Router::post('|^/api/order/finish-order|', OrderApiController::class, 'finishOrder');
