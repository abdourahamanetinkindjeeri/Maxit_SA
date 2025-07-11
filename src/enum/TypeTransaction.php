<?php

namespace App\Enum;

enum TypeTransaction : string
{
    case DEPOT = 'Depot';
    case RETRAIT = 'Retrait';
    case PAIEMENT = 'Paiement';
}