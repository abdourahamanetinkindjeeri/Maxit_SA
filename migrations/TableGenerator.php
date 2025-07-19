<?php

namespace App\Migration;

class TableGenerator
{
  public static function generateTableQueries(array $schemas, string $driver): array
  {
    $queries = [];

    foreach ($schemas as $table => $fields) {
      $columnsSql = [];
      $constraints = [];

      foreach ($fields as $name => $options) {
        $columnsSql[] = self::generateColumnDefinition($table, $name, $options, $driver);

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

      $sql = "CREATE TABLE IF NOT EXISTS $table (\n";
      $sql .= implode(",\n", array_merge($columnsSql, $constraints)) . "\n);";

      $queries[] = ['sql' => $sql];
    }

    return $queries;
  }

  private static function generateColumnDefinition(string $table, string $name, array $options, string $driver): string
  {
    $type = self::resolveType($table, $name, $options, $driver);
    $definition = "  $name $type";

    if (!empty($options['not_null'])) {
      $definition .= " NOT NULL";
    }

    if (!empty($options['default'])) {
      $default = $options['default'];
      $definition .= " DEFAULT " . (is_numeric($default) || str_starts_with($default, 'CURRENT_') ? $default : "'$default'");
    }

    return $definition;
  }

  private static function resolveType(string $table, string $name, array $options, string $driver): string
  {
    if (empty($options['type']) && !empty($options['primary']) && !empty($options['auto_increment'])) {
      return $driver === 'pgsql' ? 'SERIAL' : 'INTEGER AUTO_INCREMENT';
    }

    if (is_array($options['type']) && strtoupper($options['type'][0]) === 'ENUM') {
      return "enum_{$table}_{$name}";
    }

    return $options['type'] ?? 'TEXT';
  }
}
