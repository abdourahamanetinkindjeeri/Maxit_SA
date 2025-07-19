<?php

namespace App\Migration;

require_once __DIR__ . '/schemas.php';
require_once 'vendor/autoload.php';
require_once 'app/config/env.php';

use PDO;
use App\Migration\SQLGenerator;

use function App\Config\dump_die;


function prompt(string $label, bool $hidden = false): string
{
  echo $label;

  if ($hidden) {
    if (strncasecmp(PHP_OS, 'WIN', 3) === 0) {
      $vbscript = sys_get_temp_dir() . '/prompt_password.vbs';
      file_put_contents($vbscript, 'wscript.echo(InputBox("' . addslashes($label) . '", "", ""))');
      $command = "cscript //nologo " . escapeshellarg($vbscript);
      $password = rtrim(shell_exec($command));
      unlink($vbscript);
    } else {
      system('stty -echo');
      $password = rtrim(fgets(STDIN), "\n");
      system('stty echo');
      echo "\n";
    }
    return $password;
  }

  return rtrim(fgets(STDIN), "\n");
}

function askDatabaseCredentials(): array
{
  $dbName = prompt("📝 Nom de la base de données: ");
  $user = prompt("👤 Utilisateur de la base: ");
  $pass = prompt("🔑 Mot de passe: ", true);
  $host = prompt("📝 Hôte de la base de données (localhost): ");
  $port = prompt("📝 Port (5432): ");

  return [
    'DB_HOST' => $host ?: 'localhost',
    'DB_PORT' => $port ?: '5432',
    'DB_NAME' => $dbName,
    'DB_USER' => $user,
    'DB_PASSWORD' => $pass,
    'DSN' => DSN
  ];
}

function detectDriver(string $port): string
{
  return match ($port) {
    '3306' => 'mysql',
    '5432' => 'pgsql',
    default => 'pgsql',
  };
}

function writeEnvFile(array $config, string $path = __DIR__ . '/../.env'): void
{
  $lines = [];
  foreach ($config as $key => $value) {
    $lines[] = "$key=$value";
  }
  file_put_contents($path, implode(PHP_EOL, $lines) . PHP_EOL, FILE_APPEND); // ajoute à la fin
  echo "✅ Variables ajoutées à la fin du fichier .env : $path\n";
}

// --- PHASE 1 : Récupération des infos
$config = askDatabaseCredentials();
writeEnvFile($config);

$dbName = $config['DB_NAME'];
$user = $config['DB_USER'];
$pass = $config['DB_PASSWORD'];
$host = $config['DB_HOST'];
$port = $config['DB_PORT'];
$driver = detectDriver($port);

// --- PHASE 2 : Connexion au SGBD pour créer la base
if ($driver === 'pgsql') {
  $defaultDbName = 'postgres';
  $dsnDefault = "pgsql:host=$host;dbname=$defaultDbName;port=$port";
} else {
  $defaultDbName = 'mysql';
  $dsnDefault = "mysql:host=$host;dbname=$defaultDbName;port=$port;charset=utf8mb4";
}

try {
  $pdo = new PDO($dsnDefault, $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  if ($driver === 'pgsql') {
    $stmt = $pdo->query("SELECT 1 FROM pg_database WHERE datname = " . $pdo->quote($dbName));
    if (!$stmt->fetch()) {
      $pdo->exec("CREATE DATABASE \"$dbName\";");
      echo "✅ Base de données \"$dbName\" créée avec succès (PostgreSQL).\n";
    } else {
      echo "ℹ️ La base \"$dbName\" existe déjà.\n";
    }
  } else {
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    echo "✅ Base de données \"$dbName\" créée avec succès (MySQL).\n";
  }
} catch (\PDOException $e) {
  echo "❌ Erreur de connexion ($driver) : " . $e->getMessage() . "\n";
  exit(1);
}

// --- PHASE 3 : Connexion à la vraie base
if ($driver === 'pgsql') {
  $dsn = "pgsql:host=$host;dbname=$dbName;port=$port";
} else {
  $dsn = "mysql:host=$host;dbname=$dbName;port=$port;charset=utf8mb4";
}

try {
  $pdo = new PDO($dsn, $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Utiliser le schéma depuis schemas.php
  $schemas = require __DIR__ . '/schemas.php';

  // 1. Générer les requêtes de création de tables (remplit $enumTypes)
  $tableSQLs = [];
  foreach ($schemas as $table => $columns) {
    if (method_exists('App\Migration\SQLGenerator', 'generateCreateTable')) {
      $tableSQLs[$table] = SQLGenerator::generateCreateTable($table, $columns);
    }
  }

  // 2. Générer les types ENUM (PostgreSQL uniquement)
  if ($driver === 'pgsql') {
    if (method_exists('App\Migration\SQLGenerator', 'generateEnumTypes')) {
      $enumQueries = SQLGenerator::generateEnumTypes();
      foreach ($enumQueries as $enumSQL) {
        $pdo->exec($enumSQL);
      }
    }
  }

  // 3. Créer les tables
  foreach ($tableSQLs as $table => $createTableSQL) {
    echo "➡️ Création de la table `$table` :\n$createTableSQL\n";
    $pdo->exec($createTableSQL);
    echo "✅ Table `$table` créée avec succès.\n";
  }

  echo "🎉 Toutes les tables ont été créées avec succès.\n";
} catch (\PDOException $e) {
  echo "❌ Erreur PDO : " . $e->getMessage() . "\n";
  exit(1);
}
