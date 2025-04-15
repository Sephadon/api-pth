
# API Poker Texas Holdem

## Présentation

**API Poker Texas Holdem** est une API open source qui permet de :
- Récupérer une liste complète des 52 cartes de jeux du Poker Texas Holdem, avec un accès aux images de chaque carte.
- Récupérer une donne d'une partie de Poker Texas Holdem selon le nombre de joueurs, avec un accès aux images de chaque carte.

## Installation sur votre machine
- Assurez-vous que Composer et Symfony CLI soient installés sur votre ordinateur.

1. Créer un dossier pour le projet et aller dans ce dossier
    ```sh
    mkdir apipth
    cd apipth
    ```
2. Cloner le répertoire
    ```sh
    git clone https://github.com/Sephadon/api-pth.git
    ```
3. Installer composer pour ce projet
    ```sh
    composer install
    ```
4. Copier / coller le fichier `.env` à la racine et le renommer en `.env.local`
5. Modifier le fichier `.env.local` pour la connexion à la base de données (à ajuster selon vos informations)
    ```sh
    DATABASE_URL="mysql://user_name:password@localhost:8080/db_name?serverVersion=8.0.32&charset=utf8mb4"
    ```
6. Démarrer votre serveur MySQL
7. Création de la base de données
    ```sh
    php bin/console doctrine:database:create
    ```
8. Création de la table
    ```sh
    php bin/console doctrine:schema:update --force
    ```
9. On complète la table à l'aide des fixtures, qui récupèrent les données du fichier `playing-cards.csv` situé à la racine du projet
    ```sh
    php bin/console doctrine:fixtures:load
    ```
    -> répondre `yes` à `Careful, database "db_name" will be purged. Do you want to continue? (yes/no) [no]:`

8. Démarrer l'API
    ```sh
    php -S localhost:8080 -t public
    ```
    ou
    ```sh
    symfony server:start
    ```

## Outils et technologies
- Langage : PHP version 8.3.6
- Framework : Symfony 6.4.19
- SGBD : MySQL
- IDE : VSCodium
- Inkscape et Gimp : Images des cartes
- Test des endpoints : Postman

## Version
Version 1.0.0

## Auteur

**Stéphane Lugardon** alias **Sephadon**

## Licence

Ce projet est sous licence MIT

## Autres informations
- Il y a une limite de 5 appels par minute

## Ressources
- [symfony.com](https://symfony.com/)
- [Cours OpenClassRooms - Construisez une API REST avec Symfony](https://openclassrooms.com/fr/courses/7709361-construisez-une-api-rest-avec-symfony)