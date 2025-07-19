<?php

namespace App\Service;

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
    $repo = CompteRepository::getInstance();
    $solde = $repo->getSoldeByUserId($utilisateur->getId());
    return $solde !== null ? $solde : 0.0;
  }

  /**
   * Valide les données pour créer un compte secondaire
   */
  public function validerDonneesCompteSecondaire(string $telephone, float $solde): array
  {
    $errors = [];

    if (empty(trim($telephone))) {
      $errors[] = 'Le numéro du compte secondaire est obligatoire.';
    }

    if ($solde < 0) {
      $errors[] = 'Le solde initial ne peut pas être négatif.';
    }

    return $errors;
  }

  /**
   * Vérifie si un numéro de téléphone existe déjà pour un utilisateur
   */
  public function verifierUniciteTelephone(int $userId, string $telephone): bool
  {
    $repo = CompteRepository::getInstance();
    $comptes = $repo->getComptesByUserId($userId);

    foreach ($comptes as $compte) {
      if ($compte->getTelephone() === $telephone) {
        return false; // Le numéro existe déjà
      }
    }

    return true; // Le numéro est unique
  }

  /**
   * Vérifie si le solde du compte principal est suffisant
   */
  public function verifierSoldeDisponible(int $userId, float $montantADeduire): bool
  {
    $repo = CompteRepository::getInstance();
    $comptePrincipal = $repo->getComptePrincipal($userId);

    if (!$comptePrincipal) {
      return false;
    }

    return $comptePrincipal->getMontant() >= $montantADeduire;
  }

  /**
   * Déduit un montant du compte principal
   */
  public function deduireDuComptePrincipal(int $userId, float $montant): bool
  {
    $repo = CompteRepository::getInstance();
    $comptePrincipal = $repo->getComptePrincipal($userId);

    if (!$comptePrincipal) {
      return false;
    }

    $nouveauSolde = $comptePrincipal->getMontant() - $montant;
    return $repo->updateSoldeComptePrincipal($userId, $nouveauSolde);
  }

  /**
   * Crée un compte secondaire pour un utilisateur avec déduction du compte principal si solde spécifié
   */
  public function creerCompteSecondaire(int $userId, string $telephone, float $solde = 0.0): array
  {
    $repo = CompteRepository::getInstance();
    $result = ['success' => false, 'message' => ''];

    // Si un solde est spécifié, vérifier la disponibilité et déduire du compte principal
    if ($solde > 0) {
      if (!$this->verifierSoldeDisponible($userId, $solde)) {
        $result['message'] = 'Solde insuffisant sur le compte principal pour créer ce compte secondaire.';
        return $result;
      }

      // Déduire le montant du compte principal
      if (!$this->deduireDuComptePrincipal($userId, $solde)) {
        $result['message'] = 'Erreur lors de la déduction du compte principal.';
        return $result;
      }
    }

    // Créer le compte secondaire
    if ($repo->creerCompteSecondaire($userId, $telephone, $solde)) {
      $result['success'] = true;
      $result['message'] = 'Compte secondaire créé avec succès' . ($solde > 0 ? ' et montant déduit du compte principal.' : '.');
    } else {
      $result['message'] = 'Erreur lors de la création du compte secondaire.';

      // Si la création échoue et qu'on avait déduit du compte principal, rembourser
      if ($solde > 0) {
        $this->deduireDuComptePrincipal($userId, -$solde); // Remboursement
      }
    }

    return $result;
  }

  /**
   * Récupère tous les comptes d'un client avec les informations utilisateur
   */
  public function getComptesClientAvecUtilisateur(int $userId): array
  {
    $repo = CompteRepository::getInstance();
    return $repo->getComptesClientAvecUtilisateur($userId);
  }

  /**
   * Change le compte courant de l'utilisateur
   */
  public function changerCompte(int $userId, int $compteId): array
  {
    $repo = CompteRepository::getInstance();
    $comptes = $repo->getComptesClientAvecUtilisateur($userId);

    // Vérifier que le compte appartient bien à l'utilisateur
    foreach ($comptes as $compte) {
      if ($compte->getId() === $compteId) {
        return ['success' => true, 'message' => 'Compte changé avec succès.'];
      }
    }

    return ['success' => false, 'message' => 'Compte non trouvé ou non autorisé.'];
  }
}
