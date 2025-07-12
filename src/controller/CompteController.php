<?php

namespace App\Controller;

use App\Config\Abstract\AbstractController;
use App\Repository\CompteRepository;
use App\Config\App;

class CompteController extends AbstractController
{

  public function index(): void
  {
    // Récupérer l'utilisateur connecté
    $user = $this->session->get('user');

    if (!$user) {
      header('Location:' . BASE_URL . 'login');
      exit();
    }

    // Récupérer le solde de l'utilisateur
    $compteRepo = CompteRepository::getInstance();
    $solde = $compteRepo->getSoldeByUserId($user['id']);

    // Passer les données à la vue
    $data = [
      'user' => $user,
      'solde' => $solde ?? 0.0
    ];

    parent::renderHTML('compte/list_compte.html.php', $data);
  }

  public function create(): void
  {
    // TODO: Implement create() method.
  }

  public function show(): void
  {
    parent::renderHTML('compte/list_compte.html.php');
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

  /**
   * Affiche le solde d'un utilisateur spécifique
   */
  public function solde(): void
  {
    // Récupérer l'ID de l'utilisateur depuis l'URL
    $userId = $_GET['id'] ?? null;

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
