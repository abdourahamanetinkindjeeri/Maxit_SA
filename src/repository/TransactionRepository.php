<?php

namespace App\Repository;

use App\Core\Abstract\AbstractRepository;
use App\Core\App;
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
        FROM transaction
        WHERE transaction.utilisateur_id = :utilisateur_id
        ORDER BY transaction.date DESC
        LIMIT 10 
    ";

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

  public function getTransactionsPaginated(int $offset, int $limit): array
  {
    $request = "SELECT * FROM transaction ORDER BY date DESC LIMIT :limit OFFSET :offset";
    $stmt = $this->db->prepare($request);
    $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
    $stmt->execute();
    $transactions = [];
    while ($data = $stmt->fetch(\PDO::FETCH_ASSOC)) {
      $transactions[] = Transaction::toObject($data);
    }
    return $transactions;
  }

  public function countAllTransactions(): int
  {
    $stmt = $this->db->query("SELECT COUNT(*) as count FROM transaction");
    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    return (int)($result['count'] ?? 0);
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
