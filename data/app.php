<?php

use src\Debug\Debug;
use src\Kernel;
use src\Authorization\Request;

require __DIR__.'/config/bootstrap.php';

if (APP_DEBUG) {
    Debug::enable();
}

$kernel = new Kernel('dev');
$request = Request::createFromGlobals();
$response = $kernel->handle($request);

$response->send();
$response->terminate();
