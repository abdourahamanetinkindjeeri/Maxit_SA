<?php

namespace App\Repository;

use App\Core\Abstract\AbstractRepository;
use App\Core\App;
use App\Entity\Utilisateur;
use \PDO;
use function App\Config\dump;


class UtilisateurRepository extends AbstractRepository
{


  //    private \PDO $db;

  private static $instance = null;

  public static function getInstance()
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }
    return self::$instance;
  }


  private function __construct()
  {
    //        $this->db = Database::getInstance()->getConnection();
    //        $this->db = App::getDependency('database');
    parent::__construct();
    $this->table = 'utilisateur';
  }


  public function selectAll()
  {
    // TODO: Implement selectAll() method.
  }

  public function insert() {}

  public function update()
  {
    // TODO: Implement update() method.
  }

  public function delete()
  {
    // TODO: Implement delete() method.
  }

  public function selectById()
  {
    // TODO: Implement selectById() method.
  }
  //
  //    public function selectBy(array $filter)
  //    {
  //
  //        $request = 'SELECT * FROM {$this->table} WHERE login = :login AND password = :password';
  //        $stmt = $this->db->prepare($request);
  //
  //        $stmt->execute($filter)u;
  //    }

  public function selectBy(array $filter)
  {
    // Génère les conditions WHERE dynamiquement à partir du tableau $filter
    $conditions = [];
    foreach ($filter as $key => $value) {
      $conditions[] = "$key = :$key";
    }
    $whereClause = implode(' AND ', $conditions);

    // Attention aux guillemets doubles pour interprétation de {$this->table}
    $request = "SELECT * FROM {$this->table} WHERE $whereClause";

    $stmt = $this->db->prepare($request);
    $stmt->execute($filter);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function selectByLoginAndPassword(string $login, string $password): null|Utilisateur
  {
    $sql = "SELECT * FROM {$this->table} WHERE login = :login AND password = :password";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      'login' => $login,
      'password' => $password,
    ]);


    $data = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($data === false) {
      return null;
    }


    return Utilisateur::toObject($data) ?? null;
  }
  public function selectByLogin(string $login): null|Utilisateur
  {
    $sql = "SELECT * FROM {$this->table} WHERE login = :login";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      'login' => $login,
    ]);


    $data = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($data === false) {
      return null;
    }


    return Utilisateur::toObject($data) ?? null;
  }


  //    public function insertUtilisateur(Utilisateur $utilisateur): Utilisateur|null
  //    {
  //        try {
  //            $sql = "INSERT INTO {$this->table} (nom, prenom, login, password, cni, cni_recto, cni_verso)
  //                    VALUES (:nom, :prenom, :login, :password, :cni, :cni_recto, :cni_verso)";
  //
  //            $stmt = $this->db->prepare($sql);
  //
  //            $stmt->bindValue(':nom', $utilisateur->getNom(), PDO::PARAM_STR);
  //            $stmt->bindValue(':prenom', $utilisateur->getPrenom(), PDO::PARAM_STR);
  //            $stmt->bindValue(':login', $utilisateur->getLogin(), PDO::PARAM_STR);
  //            $stmt->bindValue(':password', $utilisateur->getPassword(), PDO::PARAM_STR);
  //            $stmt->bindValue(':cni', $utilisateur->getCni(), PDO::PARAM_STR);
  //            $stmt->bindValue(':cni_recto', $utilisateur->getCniRecto(), PDO::PARAM_STR);
  //            $stmt->bindValue(':cni_verso', $utilisateur->getCniVerso(), PDO::PARAM_STR);
  //
  //            $stmt->execute();
  //            return $utilisateur;
  //
  //        } catch (\PDOException $e) {
  //            echo "<pre>Erreur PDO : " . $e->getMessage() . "</pre>";
  //            error_log("Erreur insertion utilisateur: " . $e->getMessage());
  //            return null;
  //        }
  //    }

  public function insertUtilisateur(Utilisateur $utilisateur): ?Utilisateur
  {
    $sql = "INSERT INTO utilisateur (nom, prenom, login, password, profile_id, cni, cni_recto, cni_verso) 
            VALUES (:nom, :prenom, :login, :password, :profile_id, :cni, :cni_recto, :cni_verso)";

    $stmt = $this->db->prepare($sql);

    $stmt->bindValue(':nom', $utilisateur->getNom());
    $stmt->bindValue(':prenom', $utilisateur->getPrenom());
    $stmt->bindValue(':login', $utilisateur->getLogin());
    $stmt->bindValue(':password', $utilisateur->getPassword());
    $stmt->bindValue(':profile_id', $utilisateur->getProfile()?->getId()); // nullable
    $stmt->bindValue(':cni', $utilisateur->getCni());
    $stmt->bindValue(':cni_recto', $utilisateur->getCniRecto());
    $stmt->bindValue(':cni_verso', $utilisateur->getCniVerso());

    if ($stmt->execute()) {
      // Récupérer dernier ID inséré
      $lastId = $this->db->lastInsertId();
      $utilisateur->setId((int)$lastId);
      return $utilisateur;
    }

    return null;
  }
}
