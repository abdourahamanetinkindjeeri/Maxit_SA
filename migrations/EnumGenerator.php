<?php

namespace App\Migration;

class EnumGenerator
{
  public static function generateEnumQueries(array $schemas, string $driver): array
  {
    $queries = [];
    $definedEnums = [];

    foreach ($schemas as $table => $fields) {
      foreach ($fields as $column => $options) {
        if (is_array($options['type']) && strtoupper($options['type'][0]) === 'ENUM') {
          $enumName = "enum_{$table}_{$column}";

          if (!isset($definedEnums[$enumName])) {
            $definedEnums[$enumName] = true;

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

    return $queries;
  }
}
