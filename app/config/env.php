<?php

namespace App\Config;

require_once __DIR__ . '/../../vendor/autoload.php';
if (file_exists(__DIR__ . '/../../.env')) {
  $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
  $dotenv->load();
}

define('DSN', $_ENV['DSN'] ?? 'mysql:host=localhost;dbname=maxitsa');
define('USER', $_ENV['DB_USER'] ?? 'root');
define('PASSWORD', $_ENV['DB_PASSWORD'] ?? '');
define('TWILIO_SID', $_ENV['TWILIO_SID'] ?? '');
define('TOKEN', $_ENV['TOKEN'] ?? '');
define('PHONE', $_ENV['PHONE'] ?? '');
define('BASE_URL', $_ENV['BASE_URL'] ?? 'http://localhost:8080/');
// define('MESSAGING_SID', $_ENV['MESSAGING_SID']);

// dump_die(SID);
