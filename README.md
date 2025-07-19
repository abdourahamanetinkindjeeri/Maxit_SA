# Maxitsa

MAXITSA est une application web permettant aux clients de gérer des comptes principaux et secondaires, consulter leurs soldes, effectuer des transferts et paiements, et suivre leurs transactions. Le service commercial peut rechercher des comptes par numéro de téléphone pour consulter soldes et transactions.

## Fonctionnalités principales

- Inscription et authentification des utilisateurs
- Gestion de comptes principaux et secondaires
- Consultation du solde des comptes
- Transferts et paiements entre comptes
- Historique et suivi des transactions
- Recherche de comptes par numéro de téléphone (pour le service commercial)

## Installation

1. **Cloner le dépôt**
   ```bash
   git clone <repo_url>
   cd Maxitsa-jour3-us4
   ```
2. **Installer les dépendances PHP**
   ```bash
   composer install
   ```

## Configuration

1. **Variables d'environnement**
   Créez un fichier `.env` à la racine du projet avec les variables suivantes :

   ```env
   DB_HOST=localhost
   DB_PORT=5432 # ou 3306 pour MySQL
   DB_NAME=maxitsa
   DB_USER=utilisateur
   DB_PASSWORD=motdepasse
   BASE_URL=http://localhost:8080/
   TWILIO_SID=...        # Pour l'envoi de SMS (optionnel)
   TOKEN=...             # Pour l'envoi de SMS (optionnel)
   PHONE=...             # Pour l'envoi de SMS (optionnel)
   MESSAGING_SID=...     # Pour l'envoi de SMS (optionnel)
   DSN=...               # (optionnel, généré automatiquement)
   ```

2. **Initialiser la base de données**
   - Lancer la migration pour créer les tables :
     ```bash
     php migrations/migration.php
     ```
   - (Optionnel) Remplir la base avec des données de test :
     ```bash
     php migrations/Seeder.php
     ```

## Utilisation

1. **Lancer le serveur web PHP**
   ```bash
   php -S localhost:8080 -t public
   ```
2. **Accéder à l'application**
   Ouvrez votre navigateur à l'adresse : [http://localhost:8080](http://localhost:8080)

## Routes principales

| Méthode | URL                        | Description                             |
| ------- | -------------------------- | --------------------------------------- |
| GET     | /                          | Page de connexion                       |
| GET     | /login                     | Page de connexion                       |
| GET     | /signup                    | Page d'inscription                      |
| POST    | /inscription               | Soumission du formulaire d'inscription  |
| GET     | /logout                    | Déconnexion                             |
| GET     | /compte                    | Tableau de bord des comptes             |
| GET     | /compte/solde              | Consultation du solde du compte courant |
| POST    | /compte/ajouter-secondaire | Ajouter un compte secondaire            |
| POST    | /compte/changer-compte     | Changer de compte courant               |
| GET     | /compte/get-comptes-ajax   | Récupérer les comptes (AJAX)            |

## Auteurs

- Abdourahmane Tinkindjeeri ([abdourahamanetinkindjeeri99@gmail.com](mailto:abdourahamanetinkindjeeri99@gmail.com))

---

> Réalisé dans le cadre de l'apprentissage de la programmation orientée objet (POO) à l'ODC (Orange Digital Center).
