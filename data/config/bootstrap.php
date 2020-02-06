<?php

require __DIR__ . '/../autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/..');
$dotenv->load();

DEFINE('APP_ENV', 'prod' === getenv('APP_ENV') ? 'prod' : 'dev');
DEFINE('APP_DEBUG', 'prod' === getenv('APP_ENV') ? false : true);

/** init database connection */
\src\Database\DbManager::initEntityManager();
