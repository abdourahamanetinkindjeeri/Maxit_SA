<?php

namespace App\Translate;

enum MessageErreur: string
{
  case CNI_INVALIDE = 'Le champ : field doit être une CNI valide au Sénégal.';
  case CHAMP_REQUIS = 'Le champ  field est requis.';
  case EMAIL_INVALIDE = 'Le champ :field doit être un email valide.';

  case NUMBER_INVALID = "Le champ :field doit être un numéro de téléphone valide au Sénégal.";
  case NUMERO_OBLIGATOIRE = 'Le numéro du compte secondaire est obligatoire.';
  case SOLDE_NEGATIF = 'Le solde initial ne peut pas être négatif.';
  case ERREUR_CREATION_COMPTE_SECONDAIRE = 'Erreur lors de la création du compte secondaire.';
  case ERREUR_TRANSFERT_SOLDE = 'Erreur lors du transfert du solde.';
  case NUMERO_NON_AUTORISE = 'Numéro non autorisé pour ce compte.';
}
