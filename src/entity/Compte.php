<?php

namespace App\Entity;

use App\Config\abstract\AbstractEntity;
use App\Enum\TypeCompte;

class Compte extends AbstractEntity
{

  private int $id;

  private string $telephone;
  private string $cni;

  private string $cni_recto;
  private string $cni_verso;

  private float $montant;

  private Utilisateur $utilisateur;

  public function getUtilisateur(): Utilisateur
  {
    return $this->utilisateur;
  }

  public function setUtilisateur(Utilisateur $utilisateur): void
  {
    $this->utilisateur = $utilisateur;
  }

  public function getMontant(): float
  {
    return $this->montant;
  }

  public function setMontant(float $montant): void
  {
    $this->montant = $montant;
  }

  /**
   * @param int $id
   * @param string $telephone
   * @param string $cni
   * @param string $cni_recto
   * @param string $cni_verso
   */
  public function __construct(int $id = 0, string $telephone = '', string $cni = '', string $cni_recto = '', string $cni_verso = '', float $montant = 0)
  {
    $this->id = $id;
    $this->telephone = $telephone;
    $this->cni = $cni;
    $this->cni_recto = $cni_recto;
    $this->cni_verso = $cni_verso;
    $this->montant = $montant;
  }


  static public function toObject(array $row): static
  {
    return new self(
      (int) ($row['id'] ?? 0),
      $row['telephone'] ?? '',
      $row['cni'] ?? '',
      $row['cni_recto'] ?? '',
      $row['cni_verso'] ?? '',
      isset($row['montant']) ? (float)$row['montant'] : 0.0
    );
  }

  function toArray(): array
  {
    return [
      'id' => $this->id,
      'telephone' => $this->telephone,
      'cni' => $this->cni,
      'cni_recto' => $this->cni_recto,
      'cni_verso' => $this->cni_verso,
      'montant' => $this->montant
    ];
  }

  public function getId(): int
  {
    return $this->id;
  }

  public function setId(int $id): void
  {
    $this->id = $id;
  }

  public function getTelephone(): string
  {
    return $this->telephone;
  }

  public function setTelephone(string $telephone): void
  {
    $this->telephone = $telephone;
  }

  public function getCni(): string
  {
    return $this->cni;
  }

  public function setCni(string $cni): void
  {
    $this->cni = $cni;
  }

  public function getCniRecto(): string
  {
    return $this->cni_recto;
  }

  public function setCniRecto(string $cni_recto): void
  {
    $this->cni_recto = $cni_recto;
  }

  public function getCniVerso(): string
  {
    return $this->cni_verso;
  }

  public function setCniVerso(string $cni_verso): void
  {
    $this->cni_verso = $cni_verso;
  }
}
