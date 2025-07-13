<?php

namespace App\Enum;

enum TypeTransaction: string
{
  case RETRAIT = 'RETRAIT';
  case DEPOT = 'DEPOT';
  case VIREMENT = 'PAIEMENT';
}
