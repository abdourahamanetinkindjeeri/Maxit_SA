<?php

namespace App\Controller;

use App\Core\Abstract\AbstractController;
use App\Repository\CompteRepository;
use App\Core\App;
use App\Translate\MessageErreur;
use App\Service\CompteService;
use function App\Config\dump_die;

class CompteController extends AbstractController
{

  public function index(): void
  {
    $user = $this->session->get('user');
    if (!$user) {
      header('Location:' . BASE_URL . 'login');
      exit();
    }

    $compteService = CompteService::getInstance();
    $comptes = $compteService->getComptesClientAvecUtilisateur($user['id']);

    // Debug temporaire pour voir les comptes
    error_log("User ID: " . $user['id']);
    error_log("Comptes count: " . count($comptes));
    error_log("Comptes: " . print_r($comptes, true));

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

    // Appliquer les filtres si présents
    $filterDate = $_GET['filter_date'] ?? '';
    $filterType = $_GET['filter_type'] ?? '';

    if ($filterDate || $filterType) {
      $transactions = array_filter($transactions, function ($transaction) use ($filterDate, $filterType) {
        $transactionArray = $transaction->toArray();

        // Filtre par date
        if ($filterDate) {
          $transactionDate = $transactionArray['date'] instanceof \DateTime
            ? $transactionArray['date']->format('Y-m-d')
            : substr($transactionArray['date'], 0, 10);
          if ($transactionDate !== $filterDate) {
            return false;
          }
        }

        // Filtre par type
        if ($filterType) {
          $transactionType = $transactionArray['typeTransaction']->value ?? '';
          if ($transactionType !== $filterType) {
            return false;
          }
        }

        return true;
      });
    }

    $data = [
      'user' => $user,
      'solde' => $solde,
      'telephone' => $telephone,
      'transactions' => array_map(fn($t) => $t->toArray(), $transactions),
      'comptes' => $comptes,
      'compte_courant_id' => $compteCourant ? $compteCourant->getId() : null,
      'filter_date' => $filterDate,
      'filter_type' => $filterType
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

      // Utilisation du service pour la validation et la création
      $compteService = CompteService::getInstance();

      // Validation des données
      $errors = $compteService->validerDonneesCompteSecondaire($telephone, $solde);

      // Vérification de l'unicité du numéro de téléphone
      if (empty($errors) && !$compteService->verifierUniciteTelephone($user['id'], $telephone)) {
        $errors[] = 'Ce numéro existe déjà pour cet utilisateur.';
      }

      if ($errors) {
        $this->session->set('add_secondary_errors', $errors);
        header('Location:' . BASE_URL . 'compte');
        exit();
      }

      // Création du compte secondaire via le service
      $result = $compteService->creerCompteSecondaire($user['id'], $telephone, $solde);

      if ($result['success']) {
        $this->session->set('add_secondary_success', $result['message']);
      } else {
        $this->session->set('add_secondary_errors', [$result['message']]);
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
      $compteService = CompteService::getInstance();

      // Utiliser le service pour changer de compte
      $result = $compteService->changerCompte($user['id'], $compteId);

      if ($result['success']) {
        $this->session->set('compte_courant_id', $compteId);
        $this->session->set('change_account_success', $result['message']);
      } else {
        $this->session->set('change_account_errors', [$result['message']]);
      }
    }

    header('Location:' . BASE_URL . 'compte');
    exit();
  }

  public function getComptesAjax(): void
  {
    $user = $this->session->get('user');
    if (!$user) {
      http_response_code(401);
      echo json_encode(['error' => 'Non autorisé']);
      exit();
    }

    $compteService = CompteService::getInstance();
    $comptes = $compteService->getComptesClientAvecUtilisateur($user['id']);

    $comptesArray = [];
    foreach ($comptes as $compte) {
      $comptesArray[] = [
        'id' => $compte->getId(),
        'telephone' => $compte->getTelephone(),
        'montant' => $compte->getMontant(),
        'isPrincipal' => $compte->getId() == ($comptes[0]->getId() ?? null)
      ];
    }

    header('Content-Type: application/json');
    echo json_encode(['comptes' => $comptesArray]);
    exit();
  }

  public function transactions(): void
  {
    $user = $this->session->get('user');
    if (!$user) {
      header('Location:' . BASE_URL . 'login');
      exit();
    }
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $perPage = 10;
    $transactionService = \App\Service\TransactionService::getInstance();
    $pagination = $transactionService->getAllTransactionsPaginated($page, $perPage);
    $transactions = array_map(fn($t) => $t->toArray(), $pagination['transactions']);
    $total = $pagination['total'];
    $nbPages = (int)ceil($total / $perPage);
    parent::renderHTML('compte/transactions.html.php', [
      'transactions' => $transactions,
      'page' => $page,
      'nbPages' => $nbPages
    ]);
  }

  public function depot(): void
  {
    $user = $this->session->get('user');
    if (!$user) {
      header('Location:' . BASE_URL . 'login');
      exit();
    }
    $compteService = \App\Service\CompteService::getInstance();
    $comptes = $compteService->getComptesClientAvecUtilisateur($user['id']);
    $compteCourantId = $this->session->get('compte_courant_id');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $cibleId = (int)$_POST['cible_compte_id'];
      $montant = (float)$_POST['montant'];
      $transactionService = \App\Service\TransactionService::getInstance();
      $result = $transactionService->faireDepot($user['id'], $compteCourantId, $cibleId, $montant);
      if ($result['success']) {
        $this->session->set('depot_success', $result['message']);
      } else {
        $this->session->set('depot_error', $result['message']);
      }
      header('Location:' . BASE_URL . 'compte');
      exit();
    }

    // Afficher le formulaire
    parent::renderHTML('compte/depot.html.php', ['comptes' => $comptes, 'compte_courant_id' => $compteCourantId]);
  }

  public function annulerDepot(): void
  {
    $user = $this->session->get('user');
    if (!$user) {
      header('Location:' . BASE_URL . 'login');
      exit();
    }
    if (!isset($_GET['id'])) {
      $this->session->set('depot_error', "ID de transaction manquant.");
      header('Location:' . BASE_URL . 'compte');
      exit();
    }
    $transactionId = (int)$_GET['id'];
    $transactionService = \App\Service\TransactionService::getInstance();
    $result = $transactionService->annulerDepot($transactionId, $user['id']);
    if ($result['success']) {
      $this->session->set('depot_success', $result['message']);
    } else {
      $this->session->set('depot_error', $result['message']);
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
    $userRepo = App::get('utilisateurRepository');
    $user = $userRepo->findById((int) $userId);

    $data = [
      'user' => $user ? $user->toArray() : null,
      'solde' => $solde ?? 0.0,
      'userId' => $userId
    ];

    parent::renderHTML('compte/solde.html.php', $data);
  }
}
