<?php

namespace App\Entity;

use App\Config\abstract\AbstractEntity;
use App\Enum\TypeTransaction;

class Transaction extends AbstractEntity
{
    private int $id;
    private int $montant;
    private \DateTime $date;
    private TypeTransaction $typeTransaction;

    static public function toObject(array $row): static
    {
        return new self(
            $row['id'],
            $row['montant'],
            $row['date'],
            $row['typeTransaction']
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