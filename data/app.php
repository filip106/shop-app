<?php

use src\Kernel;
use src\Authorization\Request;

require __DIR__.'/config/bootstrap.php';

if ('dev' == true) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

include __DIR__ . '/autoload.php';

$kernel = new Kernel('dev');
$request = Request::createFromGlobals();
$response = $kernel->handle($request);

$response->send();
$response->terminate();
