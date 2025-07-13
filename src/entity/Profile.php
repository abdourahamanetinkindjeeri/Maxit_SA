<?php

namespace App\Entity;

use App\Config\abstract\AbstractEntity;

class Profile extends AbstractEntity
{
  private int $id;
  private int $libelle;



  static public function toObject(array $row): static
  {
    return new self(
      $row['id'],
      $row['libelle']
    );
  }

  function toArray(): array
  {
    return [
      'id' => $this->id,
      'libelle' => $this->libelle
    ];
  }

  public function getId(): int
  {
    return $this->id;
  }

  public function getLibelle(): string
  {
    return $this->libelle;
  }
}
