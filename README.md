# esgi_tp_symfony

# Projet Recettes - Symfony

## Description

Ce projet est une plateforme de partage de recettes réalisée avec le framework Symfony. Il inclut des fonctionnalités de gestion d'utilisateurs, de recettes, d'ingrédients, de commentaires, et plus encore.

---

## Prérequis

Avant de commencer, assurez-vous d'avoir les outils suivants installés :

- [PHP 8.3+](https://www.php.net/downloads.php)
- [Composer](https://getcomposer.org/)
- [Symfony CLI](https://symfony.com/download)
- [MySQL 8.0+](https://dev.mysql.com/downloads/)

---

## Installation

1. **Cloner le projet :**

   ```bash
   git clone https://github.com/votre-utilisateur/projet-recettes.git
   cd projet-recettes
   ```

2. **Installer les dépendances PHP :**

   ```bash
   composer install
   ```

3. **Configurer les variables d'environnement :**

   Copiez le fichier `.env` pour créer un fichier `.env.local` :

   ```bash
   cp .env .env.local
   ```

   Mettez à jour les informations de connexion à la base de données dans le fichier `.env.local` :

   ```
   DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=8.0"
   ```

4. **Créer la base de données :**

   ```bash
   symfony console doctrine:database:create
   symfony console doctrine:migrations:migrate
   ```

5. **Charger les fixtures :**

   ```bash
   symfony console doctrine:fixtures:load
   ```

---

## Lancer le projet

1. **Démarrer le serveur Symfony :**

   ```bash
   symfony server:start
   ```

   Le projet sera accessible à l'adresse : `http://127.0.0.1:8000`.

2. **Démarrer le worker Messenger :**

   Dans un terminal en plus du terminal pour lancer le serveur Symfony, lancez cette commande pour activer l'envoi de mail : 

   ```bash
   symfony console messenger:consume async -vv
   ```

3. **Compte administrateur par défaut :**

   - **Email :** `role_admin@example.com`
   - **Mot de passe :** `password`

4. **Compte utilisateur par défaut :**

   - **Email :** `role_user@example.com`
   - **Mot de passe :** `password`

5. **Compte banni par défaut :**

   - **Email :** `role_banned@example.com`
   - **Mot de passe :** `password`

---

## Fonctionnalités principales

- Gestion des utilisateurs avec rôles (Admin, User, Banned).
- Ajout, modification, suppression de recettes, ingrédients, étapes et avis côté administrateur.
- Recherche et filtres avancés sur les recettes, détail d'une recette, ajout de recettes
- Système d'avis sur les recettes.
- Gestion dynamique des ingrédients et étapes.
- Inscription avec confirmation par mail
- Réinitialisation du mot de passe avec envoi de mail.

---

## Contribution

Pour contribuer au projet :

1. **Forkez le projet.**
2. **Créez une branche pour vos modifications :** `git checkout -b ma-nouvelle-feature`.
3. **Commitez vos changements :** `git commit -m 'Ajout d'une nouvelle fonctionnalité'`.
4. **Poussez votre branche :** `git push origin ma-nouvelle-feature`.
5. **Créez une Pull Request.**

---

## Auteurs

- **Jey** - Développeur principal.

---

