<?php

use src\Parser\EnvParser;

require __DIR__ . '/../autoload.php';

$envVariables = EnvParser::parseFile(__DIR__ . '/../.env');

DEFINE('APP_ENV', 'prod' === $envVariables['APP_ENV'] ? 'prod' : 'dev');
DEFINE('APP_DEBUG', 'prod' === $envVariables['APP_ENV'] ? false : true);
