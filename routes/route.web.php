<?php

use App\Controller\SecurityController;
use App\Controller\CompteController;

$routes = [
  '/' => ['controller' => SecurityController::class, 'method' => 'create'],
  '/login' => ['controller' => SecurityController::class, 'method' => 'login'],
  '/signup' => ['controller' => SecurityController::class, 'method' => 'index'],
  '/logout' => ['controller' => SecurityController::class, 'method' => 'destroy'],
  '/inscription' => [
    'controller' => SecurityController::class,
    'method' => 'inscrire',
    'middleware' => [
      \App\Config\middlewares\CryptPassword::class
    ]
  ],
  '/compte' => ['controller' => CompteController::class, 'method' => 'show'],
  '/compte/solde' => ['controller' => CompteController::class, 'method' => 'solde'],
  '/compte/ajouter-secondaire' => ['controller' => CompteController::class, 'method' => 'ajouterSecondaire'],
  '/compte/changer-compte' => ['controller' => CompteController::class, 'method' => 'changerCompte'],

];

return $routes;
