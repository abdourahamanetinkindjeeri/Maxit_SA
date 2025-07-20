<?php

namespace App\Entity;

use App\Core\abstract\AbstractEntity;
use App\Enum\TypeTransaction;

class Transaction extends AbstractEntity
{
  private int $id;
  private int $montant;
  private \DateTime $date;
  private TypeTransaction $typeTransaction;
  private string $statut = 'VALIDE';

  public function __construct(int $id = 0, int $montant = 0, string $date = '', string $type = '')
  {
    $this->id = $id;
    $this->montant = $montant;
    $this->date = new \DateTime($date);
    $this->typeTransaction = TypeTransaction::from($type);
  }

  static public function toObject(array $row): static
  {
    $obj = new self();
    $obj->id = $row['id'];
    $obj->montant = $row['montant'];
    $obj->date = new \DateTime($row['date']);
    $obj->typeTransaction = TypeTransaction::from($row['type_transaction']);
    $obj->statut = $row['statut'] ?? 'VALIDE';
    return $obj;
  }

  function toArray(): array
  {
    return [
      'id' => $this->id,
      'montant' => $this->montant,
      'date' => $this->date,
      'typeTransaction' => $this->typeTransaction,
      'statut' => $this->statut,
    ];
  }

  public function getStatut(): string
  {
    return $this->statut;
  }
  public function setStatut(string $statut): void
  {
    $this->statut = $statut;
  }
}
