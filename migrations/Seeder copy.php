<?php

namespace App\Migration;

use PDO;

class Seeder
{
  private \PDO $pdo;

  public function __construct(\PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  public function seed(): void
  {
    // $this->insertClients();
    $this->insertProfils();
    $this->insertUtilisateurs();
    $this->insertComptes();
    $this->insertTransactions();
  }

  // private function insertClients(): void
  // {
  //   $sql = "INSERT INTO client (id, nom, email) VALUES
  //           (1, 'Entreprise Alpha', 'contact@alpha.com'),
  //           (2, 'Entreprise Beta', 'contact@beta.com')";
  //   $this->pdo->exec($sql);
  // }

  private function insertProfils(): void
  {
    $sql = "INSERT INTO profile (id, libelle) VALUES
            (1, 'Administrateur'),
            (2, 'Agent')";
    $this->pdo->exec($sql);
  }

  private function insertUtilisateurs(): void
  {
    $sql = "INSERT INTO utilisateur (
                id, nom, prenom, login, password, cni, cni_recto, cni_verso, profile_id
            ) VALUES
            (1, 'Diallo', 'Abdou', 'admin', '1234', '1234567890123', 'recto.png', 'verso.png', 1),
            (2, 'Sow', 'Moussa', 'agent', '5678', '9876543210987', 'r.png', 'v.png', 2)";
    $this->pdo->exec($sql);
  }

  private function insertComptes(): void
  {
    $sql = "INSERT INTO compte (id, client_id, montant, telephone, type_compte) VALUES
            (1, 1, 100000.00, '770000000', 'Principal'),
            (2, 1, 50000.00, '771111111', 'Secondaire'),
            (3, 2, 250000.00, '772222222', 'Principal')";
    $this->pdo->exec($sql);
  }

  private function insertTransactions(): void
  {
    $sql = "INSERT INTO transaction (id, utilisateur_id, compte_id, montant, type_transaction, date) VALUES
            (1, 1, 1, 10000.00, 'DEPOT', CURRENT_TIMESTAMP),
            (2, 2, 1, 5000.00, 'RETRAIT', CURRENT_TIMESTAMP),
            (3, 2, 2, 20000.00, 'PAIEMENT', CURRENT_TIMESTAMP)";
    $this->pdo->exec($sql);
  }
}

$dsn = 'pgsql:host=localhost;port=5432;dbname=odc_maxitsa';
$user = 'root';
$password = 'tinkin';

try {
  $pdo = new PDO($dsn, $user, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $seeder = new Seeder($pdo);
  $seeder->seed();

  echo "Base de données remplie avec succès.\n";
} catch (\PDOException $e) {
  echo "Erreur : " . $e->getMessage() . "\n";
}
