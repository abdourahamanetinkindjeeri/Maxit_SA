<?php

namespace App\Migration;

function generateSQLFromSchemas(array $schemas, string $driver = 'pgsql'): array
{
  $queries = [];
  $enumTypes = [];

  // Étape 1 : Générer les types ENUM (PostgreSQL uniquement)
  foreach ($schemas as $table => $fields) {
    foreach ($fields as $name => $options) {
      if (is_array($options['type']) && strtoupper($options['type'][0]) === 'ENUM') {
        $enumName = "enum_{$table}_{$name}";
        if (!isset($enumTypes[$enumName])) {
          $enumTypes[$enumName] = $options['type'][1];
          if ($driver === 'pgsql') {
            $values = implode(",", array_map(fn($v) => "'$v'", $options['type'][1]));
            $queries[] = [
              'sql' => "DO \$\$ BEGIN IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = '$enumName') THEN CREATE TYPE $enumName AS ENUM ($values); END IF; END \$\$;"
            ];
          }
        }
      }
    }
  }

  // Étape 2 : Générer les tables
  foreach ($schemas as $table => $fields) {
    $sql = "CREATE TABLE IF NOT EXISTS $table (\n";
    $constraints = [];

    foreach ($fields as $name => $options) {
      $line = "  $name";

      // Gérer les types
      if (!empty($options['primary']) && empty($options['type'])) {
        // AUTO-INCREMENT implicite si 'primary' est vrai
        if ($driver === 'pgsql') {
          $line .= " SERIAL";
        } elseif ($driver === 'mysql') {
          $line .= " INT AUTO_INCREMENT";
        } else {
          $line .= " INT";
        }
      } elseif (is_array($options['type']) && strtoupper($options['type'][0]) === 'ENUM') {
        $line .= " enum_{$table}_{$name}";
      } else {
        $line .= " " . $options['type'];
      }

      // NOT NULL
      if (!empty($options['not_null'])) {
        $line .= " NOT NULL";
      }

      // DEFAULT
      if (isset($options['default'])) {
        $default = $options['default'];
        $line .= " DEFAULT " . (is_numeric($default) || str_starts_with($default, 'CURRENT_') ? $default : "'$default'");
      }

      $sql .= $line . ",\n";

      // Contraintes
      if (!empty($options['primary'])) {
        $constraints[] = "PRIMARY KEY ($name)";
      }
      if (!empty($options['unique'])) {
        $constraints[] = "UNIQUE ($name)";
      }
      if (!empty($options['foreign'])) {
        [$refTable, $refField] = $options['foreign'];
        $constraints[] = "CONSTRAINT fk_{$table}_{$name} FOREIGN KEY ($name) REFERENCES $refTable($refField)";
      }
    }

    $sql .= implode(",\n", $constraints) . "\n);\n";
    $queries[] = ['sql' => $sql];
  }

  return $queries;
}
