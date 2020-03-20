<?php

use Delight\Auth\Role;
use src\Controller\AdminController;
use src\Controller\Api\CategoryApiController;
use src\Controller\Api\OrderApiController;
use src\Controller\Api\ProductApiController;
use src\Controller\Api\SecurityController;
use src\Controller\AuthController;
use src\Controller\FrontendController;
use src\routes\Router;

Router::any('|^/$|', FrontendController::class, 'index')->middleware(['order' => true]);
Router::any('|^/about$|', FrontendController::class, 'about')->middleware(['order' => true]);
Router::any('|^/profile$|', FrontendController::class, 'profile')->middleware(['order' => true, 'auth' => true]);
Router::any('|^/contact$|', FrontendController::class, 'contact')->middleware(['order' => true]);
Router::any('|^/cart|', FrontendController::class, 'cart')->middleware(['order' => true]);

Router::any('|^/login$|', AuthController::class, 'login')->middleware(['order' => true, 'auth' => false]);
Router::any('|^/register$|', AuthController::class, 'register')->middleware(['order' => true, 'auth' => true]);

Router::any('|^/product/[A-Za-z0-9]+|', FrontendController::class, 'productDetails')->middleware(['order' => true]);;
Router::any('|^/category/[A-Za-z0-9]+|', FrontendController::class, 'categoryDetails')->middleware(['order' => true]);;

/** Admin section */
Router::any('|^/admin$|', AdminController::class, 'dashboard')->middleware(['auth' => [Role::ADMIN]]);

Router::any('|^/admin/product/list$|', AdminController::class, 'productList')->middleware(['auth' => [Role::ADMIN]]);
Router::any('|^/admin/product/create$|', AdminController::class, 'productCreate')->middleware(['auth' => [Role::ADMIN]]);
Router::any('|^/admin/product/update/[0-9]+$|', AdminController::class, 'productUpdate')->middleware(['auth' => [Role::ADMIN]]);

Router::any('|^/admin/category/list$|', AdminController::class, 'categoryList')->middleware(['auth' => [Role::ADMIN]]);
Router::any('|^/admin/category/create$|', AdminController::class, 'categoryCreate')->middleware(['auth' => [Role::ADMIN]]);
Router::any('|^/admin/category/update/[0-9]+|', AdminController::class, 'categoryUpdate')->middleware(['auth' => [Role::ADMIN]]);


/** ------------------------------------- API ROUTES ------------------------------------- */
Router::get('|^/api/product|', ProductApiController::class, 'list');
Router::post('|^/api/product|', ProductApiController::class, 'create');
Router::delete('|^/api/product/[0-9]+|', ProductApiController::class, 'delete');
Router::get('|^/api/category|', CategoryApiController::class, 'list');
Router::post('|^/api/category|', CategoryApiController::class, 'create');
Router::delete('|^/api/category/[0-9]+|', CategoryApiController::class, 'delete');

Router::post('|^/api/login|', SecurityController::class, 'login');
Router::post('|^/api/logout|', SecurityController::class, 'logout');
Router::post('|^/api/register|', SecurityController::class, 'register');

Router::post('|^/api/order/add-product|', OrderApiController::class, 'addProduct');
Router::post('|^/api/order/remove-product|', OrderApiController::class, 'removeProduct');
Router::post('|^/api/order/finish-order|', OrderApiController::class, 'finishOrder');
