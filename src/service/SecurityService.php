<?php

namespace App\Service;

use App\Core\App;
use App\Config\middlewares\CryptPassword;
use App\Core\Upload;
use App\Core\Validator;
use App\Entity\Compte;
use App\Entity\Utilisateur;
use App\Repository\CompteRepository;
use App\Repository\UtilisateurRepository;
use function App\Config\dump;
use function App\Config\dump_die;

class SecurityService
{

  private static $instance = null;

  public static function getInstance()
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }
    return self::$instance;
  }

  private function __construct() {}


  public function seConnecter(string $login, string $password): Utilisateur|null
  {
    $repo = App::get('App\\Repository\\UtilisateurRepository');
    $user = $repo->selectByLogin($login);

    // Si l'utilisateur n'existe pas, retourner null
    if (!$user) {
      return null;
    }

    $crypt = App::get('App\\Core\\Middlewares\\CryptPassword');
    $userPassword = $user->getPassword();

    // Vérifier que le mot de passe hashé existe
    if (!$userPassword) {
      error_log("Utilisateur {$login} n'a pas de mot de passe hashé");
      return null;
    }

    // Vérifier le mot de passe
    if ($crypt->toVerifyPassword($password, $userPassword)) {
      return $user;
    }

    return null;
  }



  public function inscrire(Utilisateur $utilisateur, Compte $compte): ?Utilisateur
  {
    $repoUtilisateur = App::get('App\\Repository\\UtilisateurRepository');
    $repoCompte = App::get('App\\Repository\\CompteRepository');
    $pdo = App::get('App\\Core\\Database');

    try {
      $pdo->beginTransaction();

      $cniRecto = Upload::handleFileUpload('cni_recto');
      if ($cniRecto) {
        $utilisateur->setCniRecto($cniRecto);
      }

      $cniVerso = Upload::handleFileUpload('cni_verso');
      if ($cniVerso) {
        $utilisateur->setCniVerso($cniVerso);
      }

      // Insertion utilisateur
      $utilisateur = $repoUtilisateur->insertUtilisateur($utilisateur);
      if (!$utilisateur) {
        throw new \Exception("Échec insertion utilisateur");
      }

      $compte->setUtilisateur($utilisateur);

      $result = $repoCompte->insertCompte($compte);
      if (!$result) {
        throw new \Exception("Échec insertion compte");
      }

      $pdo->commit();
      return $utilisateur;
    } catch (\Exception $e) {
      $pdo->rollBack();
      error_log("Transaction échouée : " . $e->getMessage());
      return null;
    }
  }

  public function isCNIUsed($cni)
  {
    $repo = App::get('App\\Repository\\UtilisateurRepository');
    return Validator::isUniqueRow($repo->countRow('cni', $cni, 'utilisateur'));
  }

  public function isPhoneNumberUsed($telephone)
  {
    $repo = App::get('App\\Repository\\UtilisateurRepository');
    return Validator::isUniqueRow($repo->countRow('telephones', $telephone, 'compte'));
  }

  public function isLoginUsed($login)
  {
    $repo = App::get('App\\Repository\\UtilisateurRepository');
    return Validator::isUniqueRow($repo->countRow('login', $login, 'utilisateur'));
  }
}
