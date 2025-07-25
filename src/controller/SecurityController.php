<?php

namespace App\Controller;

use App\Core\Abstract\AbstractController;
use App\Entity\Compte;
use App\Entity\Utilisateur;
use App\Core\App;

use function App\Config\dump;
use function App\Config\dump_die;

class SecurityController extends AbstractController
{
  public function __construct()
  {
    parent::__construct();
    $this->layout = 'security';
  }

  public function index(): void
  {
    parent::renderHTML('utilisateur/inscription.html.php');
    //        require_once '../templates/utilisateur/inscription.html.php';
  }

  public function create(): void
  {


    //      echo $_SERVER['REMOTE_ADDR'];
    // dump_die($_SERVER['REMOTE_ADDR']);
    $this->session->unset('errors');
    $this->session->unset('old_input');
    $this->session->unset('login_error');

    parent::renderHTML('utilisateur/login.html.php');
    //        require_once '../templates/utilisateur/login.html.php';

  }

  public function show(): void
  {
    // TODO: Implement show() method.
  }

  public function edit(): void
  {
    // TODO: Implement edit() method.
  }

  public function destroy(): void
  {
    $this->session->unset('user');
    header('Location:' . BASE_URL);
    exit();
  }

  public function store(): void
  {
    // TODO: Implement store() method.
  }

  public function login(): void
  {
    $session = $this->session;
    $service = App::get('App\\Service\\SecurityService');

    $password = $_POST["password"] ?? '';
    $login = $_POST["login"] ?? '';

    $validator = App::get('App\\Core\\Validator');
    $donnees = [
      'login' => $login,
      'password' => $password,
    ];
    $regles = [
      'login' => ['required', 'email'],
      'password' => ['required'],
    ];

    $isValid = $validator->valider($donnees, $regles);

    // Stocker les données dans la session
    $session->set('old_input', $donnees);

    // Si validation échoue
    if (!$isValid) {
      $session->set('errors', $validator->getErrors());
      parent::renderHTML('utilisateur/login.html.php');
      return;
    }

    $user = $service->seConnecter($login, $password);

    if ($user !== null) {
      $session->set('user', $user->toArray());

      // Nettoyer les erreurs
      $session->unset('errors');
      $session->unset('old_input');
      $session->unset('login_error');
      // technique
      //      $service = App::getDependency('compteService');
      //      $session->set('solde', $service->getSoldeUserPrincipal($user));
      //      $transactionService = App::getDependency('transactionService');
      //      // dump_die($tran sactionRepo->getLastTenTransactions($user));
      //      // $session->set('transactions', $transactionService->getLastTenTransaction($user)->toArray());
      //      $transactions = $transactionService->getLastTenTransaction($user);
      //      $transactions = array_map(fn($t) => $t->toArray(), $transactions);
      //
      //      parent::renderHTML('compte/list_compte.html.php', ['transactions' => $transactions,'solde' => $service->getSoldeUserPrincipal($user)]);
      // $session->set('transactions', array_map(fn($t) => $t->toArray(), $transactions));
      //fin simulation
      // dump_die($transactionService->getLastTenTransaction($user));
      $this->handleSuccessfulLogin($user);
      //      header('Location:' . BASE_URL . 'compte');
      exit();
    } else {
      // Échec de connexion - utiliser les validators pour l'erreur
      $session->set('login_error', 'Identifiants incorrects. Vérifiez votre email et mot de passe.');
      parent::renderHTML('utilisateur/login.html.php');
    }
  }

  public function inscrire(): void
  {
    $service = App::get('App\\Service\\SecurityService');

    // Collecte des données du formulaire
    $donnees = [
      'nom' => $_POST['nom'] ?? '',
      'prenom' => $_POST['prenom'] ?? '',
      'telephone' => $_POST['telephone'] ?? '',
      'cni' => $_POST['cni'] ?? '',
      'password' => $_POST['password'] ?? '',
      'login' => $_POST['login'] ?? '',
      'cni_recto' => $_POST['cni_recto_url'] ?? null,
      'cni_verso' => $_POST['cni_verso_url'] ?? null,
    ];

    // Validation rapide des champs requis
    if (
      empty($donnees['nom']) || empty($donnees['prenom']) || empty($donnees['telephone']) ||
      empty($donnees['cni']) || empty($donnees['password']) || empty($donnees['login']) ||
      empty($donnees['cni_recto']) || empty($donnees['cni_verso'])
    ) {
      $this->session->set('errors', ['form' => ['Tous les champs sont obligatoires']]);
      $this->session->set('old_input', $donnees);
      parent::renderHTML('utilisateur/inscription.html.php');
      return;
    }

    $validator = App::get('App\\Core\\Validator');

    // Validation asynchrone des règles complexes
    $validationResults = [
      'telephone' => $service->isPhoneNumberUsed($donnees['telephone']),
      'cni' => $service->isCNIUsed($donnees['cni']),
      'login' => $service->isLoginUsed($donnees['login'])
    ];

    // Vérification des résultats de validation
    $errors = [];
    if (!$validationResults['telephone']) $errors['telephone'] = ['Ce numéro de téléphone est déjà utilisé'];
    if (!$validationResults['cni']) $errors['cni'] = ['Ce numéro de CNI est déjà utilisé'];
    if (!$validationResults['login']) $errors['login'] = ['Cet email est déjà utilisé'];
    if (!filter_var($donnees['login'], FILTER_VALIDATE_EMAIL)) $errors['login'] = ['Email invalide'];

    if (!empty($errors)) {
      $this->session->set('errors', $errors);
      $this->session->set('old_input', $donnees);
      parent::renderHTML('utilisateur/inscription.html.php');
      return;
    }

    // Création de l'utilisateur et du compte
    $u = new Utilisateur();
    $u->setNom($donnees['nom']);
    $u->setPrenom($donnees['prenom']);
    $u->setLogin($donnees['login']);
    $u->setPassword($donnees['password']);
    $u->setCni($donnees['cni']);
    $u->setCniVerso($donnees['cni_verso']);
    $u->setCniRecto($donnees['cni_recto']);

    $c = new Compte();
    $c->setMontant(3000000);
    $c->setUtilisateur($u);
    $c->setTelephone($donnees['telephone']);

    $user = $service->inscrire($u, $c);

    if ($user) {
      // Nettoyer la session et connecter l'utilisateur
      $this->session->unset('errors');
      $this->session->unset('old_input');
      $this->session->set('user', $user->toArray());
      $this->session->set('success_message', 'Compte créé avec succès ! Un SMS de confirmation vous sera envoyé.');

      // Redirection immédiate
      header('Location:' . BASE_URL . 'compte');
      exit();
    } else {
      $this->session->set('errors', ['registration' => ["Échec de l'inscription. Veuillez réessayer."]]);
      parent::renderHTML('utilisateur/inscription.html.php');
    }
  }

  private function handleSuccessfulLogin(Utilisateur $user): void
  {
    $session = $this->session;

    // Enregistrement de l'utilisateur connecté
    $session->set('user', $user->toArray());

    // Nettoyage des anciennes erreurs
    $session->unset('errors');
    $session->unset('old_input');
    $session->unset('login_error');

    // Récupération du solde principal
    /** @var CompteService $compteService */
    $compteService = App::get('App\\Service\\CompteService');
    $solde = $compteService->getSoldeUserPrincipal($user);
    $session->set('solde', $solde);

    // Récupération des 10 dernières transactions
    /** @var TransactionService $transactionService */
    $transactionService = App::get('App\\Service\\TransactionService');
    $transactions = $transactionService->getLastTenTransaction($user);
    $transactionsArray = array_map(fn($t) => $t->toArray(), $transactions);

    // Redirection ou affichage (selon si header peut être envoyé)
    $this->renderHTML('compte/list_compte.html.php', [
      'transactions' => $transactionsArray,
      'solde' => $solde
    ]);
  }
}
