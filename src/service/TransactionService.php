<?php

namespace App\Service;

use App\Core\App;
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
    $repo = App::get('App\\Repository\\TransactionRepository');

    return $repo->getLastTenTransactions($utilisateur);
  }

  public function getAllTransactionsPaginated(int $page = 1, int $perPage = 10): array
  {
    $repo = App::get('App\\Repository\\TransactionRepository');
    $offset = ($page - 1) * $perPage;
    $transactions = $repo->getTransactionsPaginated($offset, $perPage);
    $total = $repo->countAllTransactions();
    return [
      'transactions' => $transactions,
      'total' => $total,
      'page' => $page,
      'perPage' => $perPage
    ];
  }
}
