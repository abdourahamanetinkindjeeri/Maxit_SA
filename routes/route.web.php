<?php

use App\Controller\SecurityController;
use App\Controller\CompteController;

$routes = [
  '/' => ['controller' => SecurityController::class, 'method' => 'create'],
  '/login' => ['controller' => SecurityController::class, 'method' => 'login'],
  '/signup' => ['controller' => SecurityController::class, 'method' => 'index'],
  '/inscription' => [
    'controller' => SecurityController::class,
    'method' => 'inscrire',
    'middleware' => [
      \App\Config\middlewares\CryptPassword::class // Tableau plat
    ]
  ],
  '/compte' => ['controller' => CompteController::class, 'method' => 'show'],
  '/logout' => ['controller' => SecurityController::class, 'method' => 'destroy'],
  //    '/list-commande' => ['controller' => CommandeController::class, 'method' => 'index', 'middleware' => ['auth']],
  //    '/add-commande' => ['controller' => CommandeController::class, 'method' => 'create'],
  //    '/facture' => ['controller' => FactureController::class, 'method' => 'show'],
  //    '/enregistrer-commande' => ['controller' => CommandeController::class, 'method' => 'store'],
  //    '/deconnexion' => ['controller' => SecurityController::class, 'method' => 'destroy'],
];

return $routes; // Si ce fichier est inclus ailleurs