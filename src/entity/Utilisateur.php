<?php

namespace App\Entity;

use App\Config\abstract\AbstractEntity;
use App\Enum\TypeCompte;

class Utilisateur extends AbstractEntity
{
    private int $id;

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    private string $nom;
    private string $prenom;
    private string $login;
    private string $password;
    private ?TypeCompte $typeCompte = null;



    private string $cni;

    private string $cni_recto;
    private string $cni_verso;


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






    private ?Profile $profile;
    private array $transactions = [];

    public function __construct(
        int $id = 0,
        string $nom = '',
        string $prenom = '',
        string $login = '',
        string $password = '',
        string $cni = '',
        string $cni_recto ='',
        string $cni_verso ='',

        ?TypeCompte $typeCompte = null,
        ?Profile $profile = null,
        array $transactions = []
    ) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->login = $login;
        $this->password = $password;
       $this->cni = $cni;
       $this->cni_recto = $cni_recto;
       $this->cni_verso = $cni_verso;

//        $this->typeCompte = TypeCompte::CLIENT->value;
        $this->profile = $profile;
        $this->transactions = $transactions;
    }

    static public function toObject(array $row): static
    {
        return new self(
            (int) ($row['id'] ?? 0),
            $row['nom'] ?? '',
            $row['prenom'] ?? '',
            $row['login'] ?? '',
            $row['password'] ?? '',
           

            // isset($row['type']) ? TypeCompte::from($row['type']) : null,
            // null, // Profile à charger séparément si nécessaire
            // [] // Transactions à charger séparément si nécessaire
        );
    }

    function toArray(): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'login' => $this->login,
            'password' => $this->password,
            
            'typeCompte' => $this->typeCompte?->value ?? 'Client',
            'profile' => $this->profile?->toArray(),
            'transactions' => array_map(fn($t) => $t->toArray(), $this->transactions)
        ];
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getTypeCompte(): ?TypeCompte
    {
        return $this->typeCompte;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function getTransactions(): array
    {
        return $this->transactions;
    }

    // Setters
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }



    public function setTypeCompte(?TypeCompte $typeCompte): void
    {
        $this->typeCompte = $typeCompte;
    }

    public function setProfile(?Profile $profile): void
    {
        $this->profile = $profile;
    }

    public function addTransaction($transaction): void
    {
        $this->transactions[] = $transaction;
    }
}