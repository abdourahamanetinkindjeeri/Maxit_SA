<?php

namespace App\Service;

use App\Config\App;
use App\Entity\Utilisateur;

class TransactionService
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

  public function getLastTenTransaction(Utilisateur $utilisateur)
  {
    $repo = App::getDependency('transactionRepository');

    return $repo->getLastTenTransactions($utilisateur);
  }
}
