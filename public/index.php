<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once '../app/config/bootstrap.php';
use App\Core\App;



App::get('App\\Core\\Router')->resolve(
  isset(
    $routes
  ) ? $routes : []
);
