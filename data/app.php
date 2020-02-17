<?php

use src\Debug\Debug;
use src\Kernel;
use src\Authorization\Request;

// Images
// https://www.boadiceaperfume.com/collections/all-fragrances

require __DIR__.'/config/bootstrap.php';

if (APP_DEBUG) {
    Debug::enable();
}

$kernel = new Kernel(APP_ENV);
$request = Request::createFromGlobals();
$response = $kernel->handle($request);

$response->send();
$response->terminate();
