<?php

namespace App\Service;

use App\Config\App;
use App\Entity\Utilisateur;
use App\Repository\CompteRepository;

class CompteService
{
  private static $instance = null;


  static public function getInstance()
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }

    return self::$instance;
  }

  private function __construct() {}

  public function getSoldeUserPrincipal(Utilisateur $utilisateur): float
  {
    $repo = App::getDependency('compteRepository');
    $solde = $repo->getSoldeByUserId($utilisateur->getId());
    return $solde !== null ? $solde : 0.0;
  }
}
