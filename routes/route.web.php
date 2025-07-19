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
      \App\Core\middlewares\CryptPassword::class
    ]
  ],
  '/compte' => ['controller' => CompteController::class, 'method' => 'index'],
  '/compte/solde' => ['controller' => CompteController::class, 'method' => 'solde'],
  '/compte/ajouter-secondaire' => ['controller' => CompteController::class, 'method' => 'ajouterSecondaire'],
  '/compte/changer-compte' => ['controller' => CompteController::class, 'method' => 'changerCompte'],
  '/compte/get-comptes-ajax' => ['controller' => CompteController::class, 'method' => 'getComptesAjax'],

];

return $routes;
