<?php

namespace App\Migration;

require_once 'vendor/autoload.php';
require_once 'app/config/env.php';

use PDO;

use function App\Config\dump_die;

class Seeder
{
  private PDO $pdo;

  public function __construct(\PDO $pdo)
  {
    $this->pdo = $pdo;
  }


  private function hashPassword(): string
  {
    return password_hash('Passer123', PASSWORD_BCRYPT);
  }

  public function seed(): void
  {


    // === UTILISATEURS ===
    $utilisateurs = [
      [1, 'Admin', 'Root', 'admin@gmail.com', null, '2020999999999', 'admin_recto.png', 'admin_verso.png', 1],
      [2, 'Sow', 'Aminata', 'aminata.sow@gmail.com', null, '2020000000001', 'aminata_recto.png', 'aminata_verso.png', 1],
      [3, 'Diop', 'Cheikh', 'cheikh.diop@gmail.com', null, '2020000000002', 'cheikh_recto.png', 'cheikh_verso.png', 2],
      [4, 'Diallo', 'Moussa', 'moussa.diallo@gmail.com', null, '2020123456789', 'moussa_recto.png', 'moussa_verso.png', 3],
      [5, 'Traoré', 'Fatoumata', 'fatou.tr@gmail.com', null, '2020987654321', 'fatou_recto.png', 'fatou_verso.png', 3],
      [78, 'Diallo', 'Abdoul', 'jeeridev@gmail.com', null, '4111161818112', 'file_68727f11b28c01.98388829.png', 'file_68727f11b29154.97913753.png', null],
      [15, 'Diallo', 'Abdoul', 'amadouba29@gmail.com', null, '12345', 'file_68707358bf8685.84309867.png', 'file_68707358bfadb7.32173839.png', null],
      [16, 'AW', 'Aboubacrine', 'aw@gmail.com', null, '129019990275', 'file_68707d25f00583.50342420.png', 'file_68707d25f03398.81429853.png', null],
      [17, 'Diallo', 'Jeeri', 'jeeri@gmail.com', null, '7777', '', '', null],
      [51, 'admin', 'admin', 'admin@gmail.sn', null, '1111112111111', 'file_687168dfbaf1c9.51328370.png', 'file_687168dfbb1001.31246515.png', null]
    ];

    $stmt = $this->pdo->prepare("
            INSERT INTO utilisateur (id, nom, prenom, login, password, cni, cni_recto, cni_verso, profile_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

    foreach ($utilisateurs as &$user) {
      $user[4] = $this->hashPassword();
      $stmt->execute($user);
    }

    // === PROFILE ===
    $profiles = [
      [1, 'Administrateur'],
      [2, 'Caissier'],
      [3, 'Client']
    ];

    $stmt = $this->pdo->prepare("INSERT INTO profile (id, libelle) VALUES (?, ?)");
    foreach ($profiles as $p) {
      $stmt->execute($p);
    }

    // === COMPTE ===
    $comptes = [
      [2, 5, 150000.00, null, null],
      [43, 78, 10000.00, '772707050', 'Principal'],
      [44, 78, 100.00, '771001010', 'Secondaire'],
      [45, 78, 100000.00, '761001010', 'Secondaire'],
      [1, 51, 25000000.00, '781001010', 'Principal']
    ];

    $stmt = $this->pdo->prepare("
            INSERT INTO compte (id, client_id, montant, telephone, type_compte)
            VALUES (?, ?, ?, ?, ?)
        ");

    foreach ($comptes as $c) {
      $stmt->execute($c);
    }

    // === TRANSACTIONS ===
    $transactions = [
      [1, 3, 1, 50000.00, 'RETRAIT', '2025-07-10 23:35:02.37684'],
      [2, 3, 2, 100000.00, 'DEPOT', '2025-07-10 23:35:02.37684'],
      [3, 3, 1, 25000.00, 'PAIEMENT', '2025-07-10 23:35:02.37684'],
      [4, 78, 43, 50000.00, 'RETRAIT', '2025-07-13 11:08:45.582904'],
      [5, 78, 43, 100000.00, 'DEPOT', '2025-07-13 11:08:45.582904'],
      [6, 78, 43, 25000.00, 'PAIEMENT', '2025-07-13 11:08:45.582904'],
      [7, 78, 43, 5000.00, 'PAIEMENT', '2025-07-13 11:08:45.582904'],
      [8, 78, 43, 35000.00, 'PAIEMENT', '2025-07-13 11:08:45.582904'],
      [9, 78, 43, 250000.00, 'DEPOT', '2025-07-13 11:08:45.582904'],
      [10, 78, 43, 50000.00, 'RETRAIT', '2025-07-13 11:08:45.582904'],
      [11, 78, 43, 100000.00, 'DEPOT', '2025-07-13 11:08:45.582904'],
      [12, 78, 43, 25000.00, 'PAIEMENT', '2025-07-13 11:08:45.582904'],
      [13, 78, 43, 5000.00, 'PAIEMENT', '2025-07-13 11:08:45.582904'],
      [14, 78, 43, 35000.00, 'PAIEMENT', '2025-07-13 11:08:45.582904'],
      [15, 78, 43, 250000.00, 'DEPOT', '2025-07-13 11:08:45.582904'],
    ];

    $stmt = $this->pdo->prepare("
            INSERT INTO transaction (id, utilisateur_id, compte_id, montant, type_transaction, date)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

    foreach ($transactions as $t) {
      $stmt->execute($t);
    }

    echo "✅ Données insérées avec succès.\n";
  }
}




// $dsn = 'pgsql:host=localhost;port=5432;dbname=tinkin';
// $user = 'root';
// $password = 'tinkin';

try {
  $pdo = new PDO(DSN, USER, PASSWORD);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $seeder = new Seeder($pdo);
  $seeder->seed();

  echo "Base de données remplie avec succès.\n";
} catch (\PDOException $e) {
  echo "Erreur : " . $e->getMessage() . "\n";
}
