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

  public function __construct(int $id = 0, int $montant = 0, string $date = '', string $type = '')
  {
    $this->id = $id;
    $this->montant = $montant;
    $this->date = new \DateTime($date);
    $this->typeTransaction = TypeTransaction::from($type);
  }

  static public function toObject(array $row): static
  {
    return new self(
      $row['id'],
      $row['montant'],
      $row['date'],
      $row['type_transaction']
    );
  }

  function toArray(): array
  {
    return [
      'id' => $this->id,
      'montant' => $this->montant,
      'date' => $this->date,
      'typeTransaction' => $this->typeTransaction
    ];
  }
}
