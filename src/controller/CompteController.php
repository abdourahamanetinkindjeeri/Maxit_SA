<?php

namespace App\Controller;

use App\Config\Abstract\AbstractController;
use App\Repository\CompteRepository;
use App\Config\App;
use App\Translate\MessageErreur;

class CompteController extends AbstractController
{

  public function index(): void
  {
    $user = $this->session->get('user');
    if (!$user) {
      header('Location:' . BASE_URL . 'login');
      exit();
    }

    $compteRepo = CompteRepository::getInstance();
    $comptes = $compteRepo->getComptesByUserId($user['id']);
    // Compte courant (par défaut le premier)
    if (!$this->session->isset('compte_courant_id') && count($comptes) > 0) {
      $this->session->set('compte_courant_id', $comptes[0]->getId());
    }
    $compteCourant = null;
    foreach ($comptes as $c) {
      if ($c->getId() == $this->session->get('compte_courant_id')) {
        $compteCourant = $c;
        break;
      }
    }
    if (!$compteCourant && count($comptes) > 0) {
      $compteCourant = $comptes[0];
      $this->session->set('compte_courant_id', $compteCourant->getId());
    }
    $solde = $compteCourant ? $compteCourant->getMontant() : 0.0;
    $telephone = $compteCourant ? $compteCourant->getTelephone() : '';
    $transactionService = \App\Service\TransactionService::getInstance();
    $userEntity = \App\Entity\Utilisateur::toObject($user);
    $transactions = $transactionService->getLastTenTransaction($userEntity);
    $data = [
      'user' => $user,
      'solde' => $solde,
      'telephone' => $telephone,
      'transactions' => array_map(fn($t) => $t->toArray(), $transactions),
      'comptes' => $comptes,
      'compte_courant_id' => $compteCourant ? $compteCourant->getId() : null
    ];
    parent::renderHTML('compte/list_compte.html.php', $data);
  }

  public function create(): void
  {
    // TODO: Implement create() method.
  }

  public function show(): void
  {

    $this->index();
  }

  public function edit(): void
  {
    // TODO: Implement edit() method.
  }

  public function destroy(): void
  {
    // TODO: Implement destroy() method.
  }

  public function store(): void
  {
    // TODO: Implement store() method.
  }

  public function ajouterSecondaire(): void
  {
    $user = $this->session->get('user');
    if (!$user) {
      header('Location:' . BASE_URL . 'login');
      exit();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $telephone = trim($_POST['numero'] ?? '');
      $solde = isset($_POST['solde']) && is_numeric($_POST['solde']) ? (float)$_POST['solde'] : 0.0;
      $errors = [];
      if (!$telephone) {
        $errors[] = 'Le numéro du compte secondaire est obligatoire.';
      }
      if ($solde < 0) {
        $errors[] = 'Le solde initial ne peut pas être négatif.';
      }
      $compteRepo = CompteRepository::getInstance();
      // Vérifier unicité du numéro pour cet utilisateur
      $comptes = $compteRepo->getComptesByUserId($user['id']);
      foreach ($comptes as $c) {
        if ($c->getTelephone() === $telephone) {
          $errors[] = 'Ce numéro existe déjà pour cet utilisateur.';
          break;
        }
      }
      if ($errors) {
        $this->session->set('add_secondary_errors', $errors);
        header('Location:' . BASE_URL . 'compte');
        exit();
      }
      $ok = $compteRepo->creerCompteSecondaire($user['id'], $telephone, $solde);
      if ($ok) {
        $this->session->set('add_secondary_success', 'Compte secondaire ajouté avec succès.');
      } else {
        $this->session->set('add_secondary_errors', ['Erreur lors de la création du compte secondaire.']);
      }
      header('Location:' . BASE_URL . 'compte');
      exit();
    }
    header('Location:' . BASE_URL . 'compte');
    exit();
  }

  public function changerCompte(): void
  {
    $user = $this->session->get('user');
    if (!$user) {
      header('Location:' . BASE_URL . 'login');
      exit();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['compte_id'])) {
      $compteId = (int)$_POST['compte_id'];
      $compteRepo = CompteRepository::getInstance();
      $comptes = $compteRepo->getComptesByUserId($user['id']);
      foreach ($comptes as $c) {
        if ($c->getId() === $compteId) {
          $this->session->set('compte_courant_id', $compteId);
          break;
        }
      }
    }
    header('Location:' . BASE_URL . 'compte');
    exit();
  }

  /**
   * Affiche le solde d'un utilisateur spécifique
   */
  public function solde(): void
  {
    // Récupérer l'ID de l'utilisateur depuis l'URL
      $user = $this->session->get('user') ?? null;
      $userId = $user['id'];



    if (!$userId) {
      header('Location:' . BASE_URL . 'compte');
      exit();
    }

    // Récupérer le solde de l'utilisateur
    $compteRepo = CompteRepository::getInstance();
    $solde = $compteRepo->getSoldeByUserId((int) $userId);

    // Récupérer les informations de l'utilisateur
    $userRepo = App::getDependency('utilisateurRepository');
    $user = $userRepo->findById((int) $userId);

    $data = [
      'user' => $user ? $user->toArray() : null,
      'solde' => $solde ?? 0.0,
      'userId' => $userId
    ];

    parent::renderHTML('compte/solde.html.php', $data);
  }
}
