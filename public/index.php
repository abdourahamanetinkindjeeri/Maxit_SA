<?php

use App\Config\App;

require_once '../app/config/bootstrap.php';

App::getDependency('router')->resolve($routes);
