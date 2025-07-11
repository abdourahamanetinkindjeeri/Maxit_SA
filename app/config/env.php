<?php

namespace App\Config;

require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

define('DSN', $_ENV['DSN'] ?? 'mysql:host=localhost;dbname=maxitsa');
define('USER', $_ENV['DB_USER'] ?? 'root');
define('PASSWORD', $_ENV['DB_PASSWORD'] ?? '');
define('SID', $_ENV['SID'] ?? '');
define('TOKEN', $_ENV['TOKEN'] ?? '');
define('PHONE', $_ENV['PHONE'] ?? '');
define('BASE_URL', $_ENV['BASE_URL'] ?? 'http://localhost:9080/');
