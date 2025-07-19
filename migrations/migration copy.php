<?php

namespace App\Migration;

require_once __DIR__ . '/schemas.php';
require_once 'vendor/autoload.php';

use PDO;
use App\Migration\SQLGenerator;

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
    'DB_PASSWORD' => $pass
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

  file_put_contents($path, implode(PHP_EOL, $lines) . PHP_EOL);
  echo "✅ Fichier .env généré à : $path\n";
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
$defaultDbName = $driver === 'pgsql' ? 'postgres' : 'mysql';

$dsnDefault = $driver === 'mysql'
  ? "mysql:host=$host;dbname=$defaultDbName;port=$port;charset=utf8mb4"
  : "pgsql:host=$host;dbname=$defaultDbName;port=$port";

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
$dsn = $driver === 'mysql'
  ? "mysql:host=$host;dbname=$dbName;port=$port;charset=utf8mb4"
  : "pgsql:host=$host;dbname=$dbName;port=$port";

try {
  $pdo = new PDO($dsn, $user, $pass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Exemple de schéma simple
  $schemas = [
    'utilisateur' => [
      'id' => ['type' => 'INTEGER', 'primary' => true, 'auto_increment' => true],
      'nom' => ['type' => 'VARCHAR(255)', 'not_null' => true],
      'role' => ['type' => ['ENUM', ['admin', 'user']], 'default' => 'user']
    ]
  ];

  // Création des types ENUM si nécessaire
  $enumTypes = SQLGenerator::getEnumTypes($schemas);

  foreach ($enumTypes as $enumName => $values) {
    $enumSQL = SQLGenerator::generateEnumSQL($enumName, $values, $driver);
    $pdo->exec($enumSQL);
  }

  // Création des tables
  foreach ($schemas as $table => $columns) {
    $createTableSQL = SQLGenerator::generateCreateTableSQL($table, $columns, $driver);
    echo "➡️ Création de la table `$table` :\n$createTableSQL\n";
    $pdo->exec($createTableSQL);
    echo "✅ Table `$table` créée avec succès.\n";
  }

  echo "🎉 Toutes les tables ont été créées avec succès.\n";
} catch (\PDOException $e) {
  echo "❌ Erreur PDO : " . $e->getMessage() . "\n";
  exit(1);
}
