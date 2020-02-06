<?php

use src\Controller\AdminController;
use src\Controller\AuthController;
use src\Controller\FrontendController;
use src\routes\Router;

Router::any('/', FrontendController::class, 'index');
Router::any('/about', FrontendController::class, 'about');
Router::any('/profile', FrontendController::class, 'profile');
Router::any('/contact', FrontendController::class, 'contact');

Router::any('/login', AuthController::class, 'login');
Router::any('/register', AuthController::class, 'register');

/** Admin section */
Router::any('/admin', AdminController::class, 'dashboard');
Router::any('/admin/product/list', AdminController::class, 'productList');
Router::any('/admin/product/create', AdminController::class, 'productCreate');
