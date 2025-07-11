<?php

namespace App\Repository;

use App\Config\Abstract\AbstractRepository;
use App\Config\App;
use App\Entity\Compte;
use App\Entity\Utilisateur;
use \PDO;

class CompteRepository extends AbstractRepository
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

  public function selectByTelephone(string $telephone): null|Compte
  {
    $sql = "SELECT * FROM {$this->table} WHERE telephone = :telephome";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      'telephone' => $telephone,

    ]);


    $data = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($data === false) {
      return null;
    }


    return Utilisateur::toObject($data) ?? null;
  }

  public function insertCompte(Compte $compte): bool
  {
    try {
      // Requête avec les colonnes nécessaires et telephones au pluriel
      $sql = "INSERT INTO {$this->table} (client_id, montant, telephones) 
                VALUES (:client_id, :montant, :telephones)";

      $stmt = $this->db->prepare($sql);

      // Récupérer les numéros en tableau PHP
      $telephones = $compte->getTelephones(); // doit retourner un tableau, ex: ['+221770000001', '+221770000002']

      // Formater en string compatible PostgreSQL ARRAY
      // Exemple: '{"num1","num2"}'
      $formattedTelephones = '{' . implode(',', array_map(fn($tel) => '"' . $tel . '"', $telephones)) . '}';

      $stmt->bindValue(':client_id', $compte->getUtilisateur()->getId(), PDO::PARAM_INT);
      $stmt->bindValue(':montant', $compte->getMontant());
      $stmt->bindValue(':telephones', $formattedTelephones, PDO::PARAM_STR);
      //            $stmt->bindValue(':cni', $compte->getCni(), PDO::PARAM_STR);
      //            $stmt->bindValue(':cni_recto', $compte->getCniRecto(), PDO::PARAM_STR);
      //            $stmt->bindValue(':cni_verso', $compte->getCniVerso(), PDO::PARAM_STR);

      return $stmt->execute();
    } catch (\PDOException $e) {
      error_log("Erreur insertion compte: " . $e->getMessage());
      return false;
    }
  }
}
