<?php

use src\routes\Router;

Router::any('/', function () {
    return 'index.php';
});

Router::any('/about', function () {
    return 'about.php';
});

Router::get('/profile', function () {
    return 'user-profile.php';
});

Router::get('/login', function () {
    return 'login.php';
});

Router::get('/register', function () {
    return 'register.php';
});

Router::get('/contact', function () {
    return 'contact.php';
});