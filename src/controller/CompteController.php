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

  public function showAchat(): void
  {
    // Vérifier si l'utilisateur est connecté
    if (!$this->session->get('user')) {
      header('Location:' . BASE_URL . 'login');
      exit();
    }

    parent::renderHTML('compte/achat.html.php');
  }

  public function processAchat(): void
  {
    // Vérifier si l'utilisateur est connecté
    if (!$this->session->get('user')) {
      http_response_code(401);
      echo json_encode(['error' => 'Non autorisé']);
      return;
    }

    // Lire les données JSON du body de la requête
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Récupérer les données du formulaire
    $compteur = $data['compteur'] ?? '';
    $montant = (float)($data['montant'] ?? 0);

    // Validation des données
    if (empty($compteur) || $montant <= 0) {
      http_response_code(400);
      echo json_encode(['error' => 'Données invalides']);
      return;
    }

    try {
      // Vérifier le solde du compte avant le paiement
      $user = $this->session->get('user');
      $compteService = App::get('App\\Service\\CompteService');
      $comptes = $compteService->getComptesClientAvecUtilisateur($user['id']);

      if (empty($comptes)) {
        throw new \Exception('Aucun compte trouvé pour cet utilisateur');
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
      }

      $soldeActuel = $compteCourant ? $compteCourant->getMontant() : 0;

      // Vérifier si le solde est suffisant
      if ($soldeActuel < $montant) {
        $montantManquant = $montant - $soldeActuel;
        http_response_code(402); // Payment Required
        echo json_encode([
          'error' => 'Solde insuffisant',
          'statut' => 'insufficient_balance',
          'solde_actuel' => $soldeActuel,
          'montant_demande' => $montant,
          'montant_manquant' => $montantManquant,
          'message' => 'Votre solde est insuffisant pour effectuer ce paiement. Veuillez recharger votre compte via Orange Money.'
        ]);
        return;
      }

      // Appel à l'API Woyofal - Utiliser GET pour récupérer les données
      $apiUrl = 'https://woyofall-sn-1.onrender.com/api/achat';

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $apiUrl);
      curl_setopt($ch, CURLOPT_HTTPGET, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Content-Type: application/json'
      ]);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_TIMEOUT, 30);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

      $response = curl_exec($ch);
      $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

      if (curl_errno($ch)) {
        throw new \Exception('Erreur cURL: ' . curl_error($ch));
      }

      curl_close($ch);

      if ($httpCode !== 200) {
        throw new \Exception('Erreur de communication avec l\'API Woyofal (HTTP ' . $httpCode . ')');
      }

      $result = json_decode($response, true);

      if (!$result || !isset($result['statut']) || $result['statut'] !== 'success') {
        throw new \Exception($result['message'] ?? 'Erreur lors du traitement de l\'achat');
      }

      // Simuler un paiement en trouvant une transaction correspondante
      $transactionSimulee = $this->simulerPaiementWoyofal($compteur, $montant, $result['data']);

      // Déduire le montant du compte
      $this->deduireMontantCompte($compteCourant->getId(), $montant);

      // Enregistrer la transaction dans notre base de données
      $this->enregistrerTransactionWoyofal($transactionSimulee);

      // Retourner la réponse simulée
      header('Content-Type: application/json');
      echo json_encode([
        'statut' => 'success',
        'data' => $transactionSimulee,
        'nouveau_solde' => $soldeActuel - $montant
      ]);
    } catch (\Exception $e) {
      error_log('Erreur Woyofal API: ' . $e->getMessage());
      http_response_code(500);
      echo json_encode([
        'error' => $e->getMessage(),
        'statut' => 'error'
      ]);
    }
  }

  private function enregistrerTransactionWoyofal(array $data): void
  {
    try {
      $user = $this->session->get('user');
      $transactionService = App::get('App\\Service\\TransactionService');

      // Créer une transaction pour l'achat Woyofal
      // Utiliser le repository directement pour insérer la transaction
      $transactionRepo = App::get('App\\Repository\\TransactionRepository');

      // Insérer directement dans la base de données
      $sql = "INSERT INTO transaction (utilisateur_id, compte_id, montant, type_transaction, date, statut) 
              VALUES (?, ?, ?, 'PAIEMENT', NOW(), 'VALIDE')";

      $pdo = App::get('App\\Core\\Database')->getConnection();
      $stmt = $pdo->prepare($sql);
      $stmt->execute([
        $user['id'],
        $user['compte_id'] ?? 1,
        $data['montant']
      ]);
    } catch (\Exception $e) {
      error_log('Erreur lors de l\'enregistrement de la transaction Woyofal: ' . $e->getMessage());
    }
  }

  private function simulerPaiementWoyofal(string $compteur, float $montant, array $donneesApi): array
  {
    // Générer une référence unique
    $reference = 'ACH-' . strtoupper(uniqid());

    // Générer un code de recharge
    $codeRecharge = sprintf(
      '%04d-%04d-%04d-%04d-%04d',
      rand(1000, 9999),
      rand(1000, 9999),
      rand(1000, 9999),
      rand(1000, 9999),
      rand(1000, 9999)
    );

    // Calculer le nombre de KWT basé sur le montant
    $prixParKwh = 91; // Prix par défaut pour la tranche 1
    $nbreKwt = round($montant / $prixParKwh, 2);

    // Déterminer la tranche basée sur la consommation
    $tranche = [
      'nom' => 'Tranche 1',
      'min' => 0,
      'max' => 150,
      'prixParKwh' => $prixParKwh
    ];

    if ($nbreKwt > 150) {
      $tranche = [
        'nom' => 'Tranche 2',
        'min' => 151,
        'max' => 250,
        'prixParKwh' => 102
      ];
    }

    if ($nbreKwt > 250) {
      $tranche = [
        'nom' => 'Tranche 3',
        'min' => 251,
        'max' => 400,
        'prixParKwh' => 116
      ];
    }

    return [
      'reference' => $reference,
      'codeRecharge' => $codeRecharge,
      'nbreKwt' => $nbreKwt,
      'date' => date('Y-m-d H:i:s'),
      'tranche' => $tranche,
      'montant' => $montant,
      'compteur' => [
        'numero' => $compteur,
        'clientId' => null,
        'trancheConsommee' => 0,
        'consommationAnnuelle' => 0,
        'moisCourant' => date('Y-m'),
        'anneeCourante' => date('Y'),
        'statusTranche' => $tranche['nom'],
        'dateCreation' => date('Y-m-d H:i:s')
      ],
      'client' => [
        'id' => 1,
        'nom' => 'Client',
        'prenom' => 'Woyofal',
        'telephone' => '221000000000',
        'cni' => 'SN000000000',
        'adresse' => 'Dakar, Sénégal',
        'civilite' => 'M'
      ]
    ];
  }

  private function deduireMontantCompte(int $compteId, float $montant): void
  {
    try {
      $pdo = App::get('App\\Core\\Database')->getConnection();
      $sql = "UPDATE compte SET montant = montant - ? WHERE id = ?";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$montant, $compteId]);

      if ($stmt->rowCount() === 0) {
        throw new \Exception('Erreur lors de la mise à jour du solde');
      }
    } catch (\Exception $e) {
      error_log('Erreur lors de la déduction du montant: ' . $e->getMessage());
      throw $e;
    }
  }
}
