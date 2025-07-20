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

  public function faireDepot(int $userId, int $compteCourantId, int $compteCibleId, float $montant): array
  {
    $compteRepo = \App\Repository\CompteRepository::getInstance();
    $transactionRepo = \App\Repository\TransactionRepository::getInstance();
    $comptes = $compteRepo->getComptesByUserId($userId);
    $ids = array_map(fn($c) => $c->getId(), $comptes);
    if (!in_array($compteCourantId, $ids) || !in_array($compteCibleId, $ids)) {
      return ['success' => false, 'message' => "Comptes invalides"];
    }
    if ($compteCourantId == $compteCibleId) {
      return ['success' => false, 'message' => "Vous ne pouvez pas déposer sur le même compte."];
    }
    $source = null;
    $cible = null;
    foreach ($comptes as $c) {
      if ($c->getId() == $compteCourantId) $source = $c;
      if ($c->getId() == $compteCibleId) $cible = $c;
    }
    if (!$source || $source->getMontant() < $montant) {
      return ['success' => false, 'message' => "Solde insuffisant sur le compte courant."];
    }
    $db = $compteRepo->getDb();
    try {
      $db->beginTransaction();
      $compteRepo->updateSoldeCompte($compteCourantId, $source->getMontant() - $montant);
      $compteRepo->updateSoldeCompte($compteCibleId, $cible->getMontant() + $montant);
      $transactionRepo->createDepot($userId, $compteCibleId, $montant);
      $db->commit();
      return ['success' => true, 'message' => "Dépôt effectué avec succès."];
    } catch (\Exception $e) {
      $db->rollBack();
      return ['success' => false, 'message' => "Erreur lors du dépôt : " . $e->getMessage()];
    }
  }
}
