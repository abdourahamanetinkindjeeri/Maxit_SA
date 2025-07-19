<?php

$schemas = [
  'client' => [
    'id' => ['type' => 'INTEGER', 'primary' => true, 'auto_increment' => true],
    'nom' => ['type' => 'VARCHAR(100)', 'not_null' => true],
    'email' => ['type' => 'VARCHAR(255)', 'unique' => true, 'not_null' => true]
  ],
  'utilisateur' => [
    'id' => ['type' => 'INTEGER', 'primary' => true, 'auto_increment' => true],
    'nom' => ['type' => 'VARCHAR(100)', 'not_null' => true],
    'email' => ['type' => 'VARCHAR(255)', 'unique' => true, 'not_null' => true],
    'type' => ['type' => ['ENUM', ['commercial', 'client']], 'default' => 'client', 'not_null' => true],
    'client_id' => ['type' => 'INTEGER', 'foreign' => ['client', 'id'], 'not_null' => true],
    'created_at' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP', 'not_null' => true]
  ]
];

return $schemas;
