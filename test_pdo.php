<?php

function ask(string $question, bool $hide = false): string
{
  if ($hide && strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
    echo "$question: ";
    system('stty -echo');
    $answer = trim(fgets(STDIN));
    system('stty echo');
    echo PHP_EOL;
    return $answer;
  } else {
    echo "$question: ";
    return trim(fgets(STDIN));
  }
}

function createDatabase(PDO $pdo, string $dbName, string $engine): void
{
  try {
    if ($engine === 'pgsql') {
      $pdo->exec("CREATE DATABASE $dbName");
    } elseif ($engine === 'mysql') {
      $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
    }
    echo "✅ Base de données \"$dbName\" créée avec succès.\n";
  } catch (PDOException $e) {
    echo "⚠️  Info : " . $e->getMessage() . "\n";
  }
}

function generateSQLFromSchemas(array $schemas, string $engine = 'pgsql'): array
{
  $sqlStatements = [];

  foreach ($schemas as $tableName => $columns) {
    $defs = [];
    $foreignKeys = [];
    $primaryKey = null;
    $uniqueIndexes = [];

    foreach ($columns as $name => $options) {
      if ($name === 'id' && empty($options['type']) && !empty($options['primary'])) {
        $options['type'] = ($engine === 'mysql') ? 'INT AUTO_INCREMENT' : 'SERIAL';
      }

      $type = $options['type'];

      if (is_array($type) && strtolower($type[0]) === 'enum') {
        $enumValues = array_map(fn($v) => "'$v'", $type[1]);
        if ($engine === 'pgsql') {
          $enumName = "enum_{$tableName}_{$name}";
          $sqlStatements[] = [
            'type' => 'enum',
            'sql' => "DO $$ BEGIN IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = '$enumName') THEN CREATE TYPE $enumName AS ENUM (" . implode(',', $enumValues) . "); END IF; END $$;"
          ];
          $type = $enumName;
        } else {
          $type = "ENUM(" . implode(',', $enumValues) . ")";
        }
      }

      if ($engine === 'mysql' && strtoupper($type) === 'SERIAL') {
        $type = "INT AUTO_INCREMENT";
      }

      $definition = "$name $type";

      if (!empty($options['not_null'])) {
        $definition .= " NOT NULL";
      }

      if (isset($options['default'])) {
        $default = $options['default'];
        if (is_string($default) && strtoupper($default) !== 'CURRENT_TIMESTAMP') {
          $default = "'$default'";
        }
        $definition .= " DEFAULT $default";
      }

      if (!empty($options['primary'])) {
        $primaryKey = $name;
      }

      if (!empty($options['unique'])) {
        $uniqueIndexes[] = $name;
      }

      if (!empty($options['foreign'])) {
        [$refTable, $refColumn] = $options['foreign'];
        $constraintName = "fk_{$tableName}_{$name}";
        $foreignKeys[] = "CONSTRAINT $constraintName FOREIGN KEY ($name) REFERENCES $refTable($refColumn)";
      }

      $defs[] = $definition;
    }

    if ($primaryKey) {
      $defs[] = "PRIMARY KEY ($primaryKey)";
    }

    foreach ($uniqueIndexes as $col) {
      $defs[] = "UNIQUE ($col)";
    }

    $defs = array_merge($defs, $foreignKeys);
    $createTableSQL = "CREATE TABLE IF NOT EXISTS $tableName (\n  " . implode(",\n  ", $defs) . "\n)";

    if ($engine === 'mysql') {
      $createTableSQL .= " ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    }

    $createTableSQL .= ";";

    $sqlStatements[] = ['type' => 'table', 'sql' => $createTableSQL];
  }

  return $sqlStatements;
}

// 🎯 Configuration
$engine = 'pgsql'; // ou 'mysql'

$dbName = ask("📝 Entrez le nom de la base de données");
$dbUser = ask("👤 Entrez l'utilisateur de la base");
$dbPass = ask("🔑 Entrez le mot de passe", true);

// 🔌 Connexion au serveur sans base
$dsnBase = $engine === 'pgsql'
  ? "pgsql:host=localhost"
  : "mysql:host=localhost;charset=utf8mb4";

try {
  $pdoBase = new PDO($dsnBase, $dbUser, $dbPass);
  $pdoBase->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // 📦 Création de la base
  createDatabase($pdoBase, $dbName, $engine);
} catch (PDOException $e) {
  echo "❌ Erreur de connexion (initiale) : " . $e->getMessage() . "\n";
  exit(1);
}

// 🔁 Connexion à la base cible
$dsn = $engine === 'pgsql'
  ? "pgsql:host=localhost;dbname=$dbName"
  : "mysql:host=localhost;dbname=$dbName;charset=utf8mb4";

try {
  $pdo = new PDO($dsn, $dbUser, $dbPass);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $schemas = [
    'utilisateur' => [
      'id' => ['type' => '', 'primary' => true],
      'nom' => ['type' => 'VARCHAR(100)', 'not_null' => true],
      'email' => ['type' => 'VARCHAR(255)', 'unique' => true],
      'type' => ['type' => ['ENUM', ['admin', 'client']], 'default' => 'client'],
      'created_at' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP']
    ],
    'transaction' => [
      'id' => ['type' => '', 'primary' => true],
      'utilisateur_id' => ['type' => 'INT', 'foreign' => ['utilisateur', 'id']],
      'montant' => ['type' => 'NUMERIC(15, 2)', 'not_null' => true],
      'date' => ['type' => 'TIMESTAMP', 'not_null' => true, 'default' => 'CURRENT_TIMESTAMP']
    ]
  ];

  $queries = generateSQLFromSchemas($schemas, $engine);

  foreach ($queries as $q) {
    echo "➡️  Exécution : \n" . $q['sql'] . "\n";
    $pdo->exec($q['sql']);
    echo "✅ Succès\n\n";
  }

  echo "🎉 Base de données \"$dbName\" initialisée avec succès.\n";
} catch (PDOException $e) {
  echo "❌ Erreur PDO : " . $e->getMessage() . "\n";
}
