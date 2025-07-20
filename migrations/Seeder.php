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
      ['Admin', 'Root', 'admin@gmail.com', null, '2020999999999', 'admin_recto.png', 'admin_verso.png', 1],
      ['Sow', 'Aminata', 'aminata.sow@gmail.com', null, '2020000000001', 'aminata_recto.png', 'aminata_verso.png', 1],
      ['Diop', 'Cheikh', 'cheikh.diop@gmail.com', null, '2020000000002', 'cheikh_recto.png', 'cheikh_verso.png', 2],
      ['Diallo', 'Moussa', 'moussa.diallo@gmail.com', null, '2020123456789', 'moussa_recto.png', 'moussa_verso.png', 3],
      ['Traoré', 'Fatoumata', 'fatou.tr@gmail.com', null, '2020987654321', 'fatou_recto.png', 'fatou_verso.png', 3],
      ['Diallo', 'Abdoul', 'jeeridev@gmail.com', null, '4111161818112', 'file_68727f11b28c01.98388829.png', 'file_68727f11b29154.97913753.png', null],
      ['AW', 'Aboubacrine', 'aw@gmail.com', null, '129019990275', 'file_68707d25f00583.50342420.png', 'file_68707d25f03398.81429853.png', 1],
      ['Diallo', 'Jeeri', 'jeeri@gmail.com', null, '7777', 'file_68707358bf8685.84309867.png', 'file_68707358bf8685.84309867.png', 1],
      ['douvewane', 'Coach WANE', 'douvewane85@gmail.sn', null, '1111112111111', 'file_687168dfbaf1c9.51328370.png', 'file_687168dfbb1001.31246515.png', 2]
    ];

    $stmt = $this->pdo->prepare("
            INSERT INTO utilisateur (nom, prenom, login, password, cni, cni_recto, cni_verso, profile_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

    foreach ($utilisateurs as &$user) {
      $user[3] = $this->hashPassword(); // Le mot de passe est maintenant à l'index 3
      $stmt->execute($user);
    }

    // === PROFILE ===
    $profiles = [
      ['Client'],
      ['Commercial']
    ];

    $stmt = $this->pdo->prepare("INSERT INTO profile (libelle) VALUES (?)");
    foreach ($profiles as $p) {
      $stmt->execute($p);
    }

    // === COMPTE ===
    $comptes = [
      [5, 150000.00, null, null],
      [6, 10000.00, '772707050', 'Principal'],
      [6, 100.00, '771001010', 'Secondaire'],
      [6, 100000.00, '761001010', 'Secondaire'],
      [51, 25000000.00, '781001010', 'Principal']
    ];

    $stmt = $this->pdo->prepare("
            INSERT INTO compte (client_id, montant, telephone, type_compte)
            VALUES (?, ?, ?, ?)
        ");

    foreach ($comptes as $c) {
      $stmt->execute($c);
    }

    // === TRANSACTIONS ===
    $transactions = [
      [3, 1, 50000.00, 'RETRAIT', '2025-07-10 23:35:02.37684'],
      [3, 2, 100000.00, 'DEPOT', '2025-07-10 23:35:02.37684'],
      [3, 1, 25000.00, 'PAIEMENT', '2025-07-10 23:35:02.37684'],
      [6, 43, 50000.00, 'RETRAIT', '2025-07-13 11:08:45.582904'],
      [6, 43, 100000.00, 'DEPOT', '2025-07-13 11:08:45.582904'],
      [6, 43, 25000.00, 'PAIEMENT', '2025-07-13 11:08:45.582904'],
      [6, 43, 5000.00, 'PAIEMENT', '2025-07-13 11:08:45.582904'],
      [6, 43, 35000.00, 'PAIEMENT', '2025-07-13 11:08:45.582904'],
      [6, 43, 250000.00, 'DEPOT', '2025-07-13 11:08:45.582904'],
      [6, 43, 50000.00, 'RETRAIT', '2025-07-13 11:08:45.582904'],
      [6, 43, 100000.00, 'DEPOT', '2025-07-13 11:08:45.582904'],
      [6, 43, 25000.00, 'PAIEMENT', '2025-07-13 11:08:45.582904'],
      [6, 43, 5000.00, 'PAIEMENT', '2025-07-13 11:08:45.582904'],
      [6, 43, 35000.00, 'PAIEMENT', '2025-07-13 11:08:45.582904'],
      [6, 43, 250000.00, 'DEPOT', '2025-07-13 11:08:45.582904'],
    ];

    $stmt = $this->pdo->prepare("
            INSERT INTO transaction (utilisateur_id, compte_id, montant, type_transaction, date)
            VALUES (?, ?, ?, ?, ?)
        ");

    foreach ($transactions as $t) {
      $stmt->execute($t);
    }

    echo "✅ Données insérées avec succès.\n";
  }
}



try {
  $pdo = new PDO(DSN, USER, PASSWORD);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $seeder = new Seeder($pdo);
  $seeder->seed();

  echo "Base de données remplie avec succès.\n";
} catch (\PDOException $e) {
  echo "Erreur : " . $e->getMessage() . "\n";
}
