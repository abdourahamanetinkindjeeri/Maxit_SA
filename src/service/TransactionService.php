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

  public function annulerDepot(int $transactionId, int $userId): array
  {
    $transactionRepo = \App\Repository\TransactionRepository::getInstance();
    $compteRepo = \App\Repository\CompteRepository::getInstance();
    // Récupérer la transaction
    $db = $compteRepo->getDb();
    $sql = "SELECT * FROM transaction WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->execute(['id' => $transactionId]);
    $transaction = $stmt->fetch(\PDO::FETCH_ASSOC);
    if (!$transaction) {
      return ['success' => false, 'message' => "Transaction introuvable."];
    }
    if ($transaction['type_transaction'] !== 'DEPOT') {
      return ['success' => false, 'message' => "Seuls les dépôts peuvent être annulés."];
    }
    if ($transaction['statut'] === 'ANNULE') {
      return ['success' => false, 'message' => "Cette transaction est déjà annulée."];
    }
    if ((int)$transaction['utilisateur_id'] !== $userId) {
      return ['success' => false, 'message' => "Vous ne pouvez annuler que vos propres dépôts."];
    }
    $compteReceveurId = (int)$transaction['compte_id'];
    $montant = (float)$transaction['montant'];
    // Trouver le compte source (celui qui a fait le dépôt)
    // Ici, on suppose que le compte courant au moment du dépôt est le compte source
    // Pour l'annulation, on crédite ce compte (userId doit posséder ce compte)
    // On va chercher le compte courant de l'utilisateur au moment de l'annulation
    $comptes = $compteRepo->getComptesByUserId($userId);
    $compteSource = null;
    foreach ($comptes as $c) {
      if ($c->getId() != $compteReceveurId) {
        $compteSource = $c;
        break;
      }
    }
    if (!$compteSource) {
      return ['success' => false, 'message' => "Impossible de retrouver le compte source."];
    }
    // Vérifier que le compte receveur a encore le montant
    $compteReceveur = null;
    foreach ($comptes as $c) {
      if ($c->getId() == $compteReceveurId) {
        $compteReceveur = $c;
        break;
      }
    }
    if (!$compteReceveur || $compteReceveur->getMontant() < $montant) {
      return ['success' => false, 'message' => "Le montant n'est plus disponible sur le compte receveur."];
    }
    try {
      $db->beginTransaction();
      $compteRepo->updateSoldeCompte($compteReceveurId, $compteReceveur->getMontant() - $montant);
      $compteRepo->updateSoldeCompte($compteSource->getId(), $compteSource->getMontant() + $montant);
      $transactionRepo->annulerDepot($transactionId);
      $db->commit();
      return ['success' => true, 'message' => "Dépôt annulé avec succès."];
    } catch (\Exception $e) {
      $db->rollBack();
      return ['success' => false, 'message' => "Erreur lors de l'annulation : " . $e->getMessage()];
    }
  }
}
