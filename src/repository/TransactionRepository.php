<?php

namespace App\Repository;

use App\Config\Abstract\AbstractRepository;
use App\Config\App;
use App\Entity\Transaction;
use App\Entity\Utilisateur;

class TransactionRepository extends AbstractRepository
{

  private static $instance = null;

  static public function getInstance()
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }

    return self::$instance;
  }

  private function __construct()
  {
    parent::__construct();
    $this->table = 'transaction';
  }

  public function getLastTenTransactions(Utilisateur $user): array
  {
    $request = "
        SELECT transaction.*
        FROM utilisateur
        JOIN compte ON compte.client_id = utilisateur.id
        JOIN transaction ON transaction.compte_id = compte.id
        WHERE utilisateur.id = :utilisateur_id
        ORDER BY transaction.date DESC
        LIMIT 10 
    ";
    // ORDER BY transaction.date DESC

    $stmt = $this->db->prepare($request);
    $stmt->execute([
      'utilisateur_id' => $user->getId()
    ]);

    $transactions = [];

    while ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
      $transactions[] = Transaction::toObject($data);
    }

    return $transactions;
  }


  public function selectAll()
  {
    // TODO: Implement selectAll() method.
  }

  public function insert() {}

  public function update()
  {
    // TODO: Implement update() method.
  }

  public function delete()
  {
    // TODO: Implement delete() method.
  }

  public function selectById()
  {
    // TODO: Implement selectById() method.
  }

  public function selectBy(array $filter)
  {
    // TODO: Implement selectById() method.
  }
}
