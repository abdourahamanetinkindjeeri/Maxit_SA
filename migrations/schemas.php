<?php

// $schemas = [
//   'client' => [
//     'id' => ['type' => 'INTEGER', 'primary' => true, 'auto_increment' => true],
//     'nom' => ['type' => 'VARCHAR(100)', 'not_null' => true],
//     'email' => ['type' => 'VARCHAR(255)', 'unique' => true, 'not_null' => true]
//   ],
//   'utilisateur' => [
//     'id' => ['type' => 'INTEGER', 'primary' => true, 'auto_increment' => true],
//     'nom' => ['type' => 'VARCHAR(100)', 'not_null' => true],
//     'email' => ['type' => 'VARCHAR(255)', 'unique' => true, 'not_null' => true],
//     'type' => ['type' => ['ENUM', ['commercial', 'client']], 'default' => 'client', 'not_null' => true],
//     'client_id' => ['type' => 'INTEGER', 'foreign' => ['client', 'id'], 'not_null' => true],
//     'created_at' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP', 'not_null' => true]
//   ]
// ];

// return $schemas;


$schemas = [
  'compte' => [
    'id' => ['type' => 'INTEGER', 'primary' => true, 'auto_increment' => true],
    'client_id' => ['type' => 'INTEGER', 'not_null' => true],
    'montant' => ['type' => 'NUMERIC(15,2)', 'not_null' => true],
    'telephone' => ['type' => 'VARCHAR(14)'],
    'type_compte' => ['type' => ['ENUM', ['Principal', 'Secondaire']]],
  ],
  'profile' => [
    'id' => ['type' => 'INTEGER', 'primary' => true, 'auto_increment' => true],
    'libelle' => ['type' => 'VARCHAR(100)', 'not_null' => true, 'unique' => true],
  ],
  'transaction' => [
    'id' => ['type' => 'INTEGER', 'primary' => true, 'auto_increment' => true],
    'utilisateur_id' => ['type' => 'INTEGER'],
    'compte_id' => ['type' => 'INTEGER', 'not_null' => true],
    'montant' => ['type' => 'NUMERIC(15,2)', 'not_null' => true],
    'type_transaction' => ['type' => ['ENUM', ['RETRAIT', 'DEPOT', 'PAIEMENT']], 'not_null' => true],
    'date' => ['type' => 'TIMESTAMP', 'default' => 'CURRENT_TIMESTAMP', 'not_null' => true],
    'statut' => ['type' => 'VARCHAR(20)', 'default' => 'VALIDE', 'not_null' => true],
  ],
  'utilisateur' => [
    'id' => ['type' => 'INTEGER', 'primary' => true, 'auto_increment' => true],
    'nom' => ['type' => 'VARCHAR(100)', 'not_null' => true],
    'prenom' => ['type' => 'VARCHAR(100)', 'not_null' => true],
    'login' => ['type' => 'VARCHAR(100)', 'not_null' => true, 'unique' => true],
    'password' => ['type' => 'VARCHAR(255)', 'not_null' => true],
    'cni' => ['type' => 'VARCHAR(20)', 'not_null' => true, 'unique' => true],
    'cni_recto' => ['type' => 'VARCHAR(255)', 'not_null' => true, 'unique' => true],
    'cni_verso' => ['type' => 'VARCHAR(255)', 'not_null' => true, 'unique' => true],
    'profile_id' => ['type' => 'INTEGER'],
  ],
];

return $schemas;
