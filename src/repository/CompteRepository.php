<?php

namespace App\Repository;

use App\Core\Abstract\AbstractRepository;
use App\Core\App;
use App\Entity\Compte;
use App\Entity\Utilisateur;
use \PDO;

class CompteRepository extends AbstractRepository
{



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
    parent::__construct();

    $this->table = "compte";
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

  public function selectByTelephone(string $telephone): ?Compte
  {
    $sql = "SELECT * FROM {$this->table} WHERE telephone = :telephone";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['telephone' => $telephone]);
    $data = $stmt->fetch(\PDO::FETCH_ASSOC);
    if ($data === false) {
      return null;
    }
    return Compte::toObject($data);
  }

  /**
   * Récupère le solde d'un utilisateur par son ID
   */
  public function getSoldeByUserId(int $userId): ?float
  {
    $sql = "SELECT montant FROM {$this->table} WHERE client_id = :user_id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['user_id' => $userId]);

    $result = $stmt->fetch(\PDO::FETCH_ASSOC);

    return $result ? (float) $result['montant'] : null;
  }

  /**
   * Récupère le compte complet d'un utilisateur avec ses informations
   */
  public function getCompteByUserId(int $userId): ?Compte
  {
    $sql = "SELECT c.*, u.nom, u.prenom, u.login 
            FROM {$this->table} c 
            INNER JOIN utilisateur u ON c.client_id = u.id 
            WHERE c.client_id = :user_id";

    $stmt = $this->db->prepare($sql);
    $stmt->execute(['user_id' => $userId]);

    $data = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($data === false) {
      return null;
    }

    return Compte::toObject($data);
  }

  /**
   * Récupère tous les comptes avec les informations des utilisateurs
   */
  public function getAllComptesWithUsers(): array
  {
    $sql = "SELECT c.*, u.nom, u.prenom, u.login 
            FROM {$this->table} c 
            INNER JOIN utilisateur u ON c.client_id = u.id 
            ORDER BY c.id";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    return array_map(fn($row) => Compte::toObject($row), $results);
  }

  //  A refaire
  public function insertCompte(Compte $compte): bool
  {
    try {
      $sql = "INSERT INTO {$this->table} (client_id, montant, telephone) 
                VALUES (:client_id, :montant, :telephone)";
      $stmt = $this->db->prepare($sql);
      $stmt->bindValue(':client_id', $compte->getUtilisateur()->getId(), PDO::PARAM_INT);
      $stmt->bindValue(':montant', $compte->getMontant());
      $stmt->bindValue(':telephone', $compte->getTelephone(), PDO::PARAM_STR);
      return $stmt->execute();
    } catch (\PDOException $e) {
      error_log("Erreur insertion compte: " . $e->getMessage());
      return false;
    }
  }

  public function getSoldeByNumero(int $userId, string $numero): ?float
  {
    $sql = "SELECT montant, telephone FROM {$this->table} WHERE client_id = :user_id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['user_id' => $userId]);
    $compte = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$compte) return null;
    if ($numero === ($compte['telephone'] ?? null)) {
      return (float)$compte['montant'];
    }
    return null;
  }
}
