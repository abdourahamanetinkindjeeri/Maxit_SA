<?php

namespace App\Service;

use App\Config\App;
use App\Config\middlewares\CryptPassword;
use App\Config\Upload;
use App\Config\Validator;
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
  //    public function seConnecter(string $login, string $password) : Utilisateur|null
  //    {
  //        $repo = UtilisateurRepository::getInstance();
  //        $user = $repo->selectByLoginAndPassword($login, $password);
  //
  //        return $user ?? null;
  //
  //    }

  public function seConnecter(string $login, string $password): Utilisateur|null
  {
    $repo = App::getDependency('utilisateurRepository');
    $user = $repo->selectByLogin($login);
    $crypt = App::getDependency('cryptPassword');
    if ($crypt->toVerifyPassword($password, $user->getPassword()))
      return $user;
    return  null;
  }

  //    public function inscrire(Utilisateur $utilisateur) : Utilisateur|null
  //    {
  ////        dump_die($utilisateur);
  //        $repo = UtilisateurRepository::getInstance();
  //        $cniRecto = Upload::handleFileUpload('cni_recto');
  //        if ($cniRecto) {
  //            $utilisateur->setCniRecto($cniRecto);
  //        }
  //
  //        $cniVerso = Upload::handleFileUpload('cni_verso');
  //        if ($cniVerso) {
  //            $utilisateur->setCniVerso($cniVerso);
  //        }
  //        return $repo->insertUtilisateur($utilisateur);
  //
  //    }

  public function inscrire(Utilisateur $utilisateur, Compte $compte): ?Utilisateur
  {
    $repoUtilisateur = App::getDependency('utilisateurRepository');
    $repoCompte = App::getDependency('compteRepository');
    $pdo = App::getDependency('database'); // Assure-toi d'avoir une méthode pour récupérer le PDO

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
    $repo = App::getDependency('utilisateurRepository');
    return Validator::isUniqueRow($repo->countRow('cni', $cni, 'utilisateur'));
  }

  public function isPhoneNumberUsed($telephone)
  {
    $repo = App::getDependency('utilisateurRepository');
    return Validator::isUniqueRow($repo->countRow('telephones', $telephone, 'compte'));
  }

  public function isLoginUsed($login)
  {
    $repo = App::getDependency('utilisateurRepository');
    return Validator::isUniqueRow($repo->countRow('login', $login, 'utilisateur'));
  }
}
