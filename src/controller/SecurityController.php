<?php

namespace App\Controller;

use App\Config\Abstract\AbstractController;
use App\Config\Validator;
use App\Entity\Compte;
use App\Entity\Utilisateur;
use App\Service\SecurityService;
use App\Config\App;
use Twilio\Rest\Client;

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
    // TODO: Implement destroy() method.
  }

  public function store(): void
  {
    // TODO: Implement store() method.
  }

  public function login(): void
  {
    $session = $this->session;

    $service = App::getDependency('securityService');

    $password = $_POST["password"] ?? '';
    $login = $_POST["login"] ?? '';

    $validator = App::getDependency('validator');
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

      header('Location:' . BASE_URL . 'compte');
      exit();
    } else {
      // Échec de connexion
      $session->set('login_error', 'Identifiants incorrects');
      parent::renderHTML('utilisateur/login.html.php');
    }
  }

  public function inscrire(): void
  {
    $service = App::getDependency('securityService');

    // Collecte des données du formulaire
    $donnees = [
      'nom' => $_POST['nom'] ?? '',
      'prenom' => $_POST['prenom'] ?? '',
      'telephone' => $_POST['telephone'] ?? '',
      'cni' => $_POST['cni'] ?? '',
      'password' => $_POST['password'] ?? '',
      'login' => $_POST['login'] ?? '',
      'cni_recto' => $_FILES['cni_recto'] ?? null,
      'cni_verso' => $_FILES['cni_verso'] ?? null,
    ];

    $validator = App::getDependency('validator');

    // Définition des règles de validation
    $regles = [
      'nom' => ['required'],
      'prenom' => ['required'],
      'telephone' => [
        'required',
        'phone',
        'unique' => function ($value) use ($service) {
          return $service->isPhoneNumberUsed($value);
        }
      ],
      'cni' => [
        'required',
        'cni',
        'unique' => function ($value) use ($service) {
          return $service->isCNIUsed($value);
        }
      ],
      'password' => ['required'],
      'login' => [
        'required',
        'email',
        'unique' => function ($value) use ($service) {
          return $service->isLoginUsed($value);
        }
      ],
      'cni_recto' => ['file'],
      'cni_verso' => ['file'],
    ];

    $isValid = $validator->valider($donnees, $regles);

    // Stockage des données dans la session
    $this->session->set('old_input', $donnees);

    if (!$isValid) {
      $this->session->set('errors', $validator->getErrors());
      parent::renderHTML('utilisateur/inscription.html.php');
      return;
    }

    // Création de l'utilisateur et du compte
    $u = new Utilisateur();
    $u->setNom($donnees['nom']);
    $u->setPrenom($donnees['prenom']);
    $u->setLogin($donnees['login']);
    $u->setPassword($donnees['password']); // Le mot de passe sera crypté par le middleware
    $u->setCni($donnees['cni']);
    // $u->setCniRecto($this->handleFileUpload($cni_recto));
    // $u->setCniVerso($this->handleFileUpload($cni_verso));

    $c = new Compte();
    $c->setMontant(10000);
    $c->setUtilisateur($u);
    $c->setTelephones($donnees['telephone']);

    $user = $service->inscrire($u, $c);

    if ($user) {
      // Envoi du SMS de bienvenue
      // $this->sendWelcomeSMS($donnees['telephone']);
      header('Location:' . BASE_URL . 'compte');
    } else {
      $this->session->set('errors', ['registration' => ["Échec de l'inscription. Veuillez réessayer."]]);
      parent::renderHTML('utilisateur/inscription.html.php');
    }
  }



  private function sendWelcomeSMS(string $phoneNumber): void
  {
    $sid = getenv('TWILIO_SID');
    $token = getenv('TWILIO_AUTH_TOKEN');
    $from = getenv('TWILIO_PHONE_NUMBER');

    try {
      $twilio = new Client($sid, $token);
      $twilio->messages->create(
        $phoneNumber,
        [
          'from' => $from,
          'body' => 'Bienvenue! Votre compte a été créé avec succès.'
        ]
      );
    } catch (\Exception $e) {
      error_log('Erreur SMS Twilio : ' . $e->getMessage());
    }
  }
}
