# Gestion-disponibilit-s-vehicule-wikicampers

# Gestion des Disponibilités de Véhicules en Location

## Introduction

Ce projet a pour objectif de gérer les disponibilités et les tarifs de location de véhicules. Il permet de créer, modifier, supprimer des véhicules ainsi que leurs disponibilités. Il inclut également un formulaire de recherche pour trouver des véhicules disponibles à des dates spécifiques.

## Prérequis

- PHP >= 7.4
- Composer
- Symfony CLI
- MySQL
- WAMP (Windows), MAMP (macOS), ou LAMP (Linux) pour la gestion du serveur local et de la base de données
- PHPMyAdmin pour la gestion de la base de données
- xDebug pour le débogage

## Installation

### Cloner le dépôt

Clonez ce dépôt sur votre machine locale :

```bash
git clone <URL_DU_DEPOT>
cd <NOM_DU_DEPOT>


Installer les dépendances

Installez les dépendances PHP avec Composer :
composer install

Configurer la base de données

Copiez le fichier .env en .env.local et configurez la connexion à la base de données MySQL :

cp .env .env.local

Ouvrez le fichier .env.local et modifiez la ligne pour utiliser MySQL :
DATABASE_URL="mysql://root:@127.0.0.1:3306/wikicamperssssss?serverVersion=8.0.31&charset=utf8mb4"

Créer la base de données

Créez la base de données et exécutez les migrations :
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate


Lancer le serveur Symfony

Démarrez le serveur Symfony :
symfony server:start

Le projet sera accessible à l'adresse http://127.0.0.1:8000.

Utilisation
Accéder à l'application

Ouvrez votre navigateur et allez à l'adresse http://127.0.0.1:8000/admin/vehicules pour gérer les véhicules et leurs disponibilités.
Créer un véhicule

Cliquez sur "Créer un nouveau véhicule" et remplissez le formulaire avec les informations du véhicule.
Ajouter des disponibilités

Après avoir créé un véhicule, vous pouvez ajouter des disponibilités en définissant les dates de début et de fin, le prix par jour et le statut de disponibilité.
Rechercher des véhicules disponibles

Utilisez le formulaire de recherche pour saisir les dates de départ et de retour afin de trouver les véhicules disponibles.
Difficultés Rencontrées et Surmontées

    Apprentissage du PHP :
        L'apprentissage du PHP a été assez court, mais intensif. J'ai utilisé les vidéos de Grafikart pour apprendre Symfony, ce qui a été très utile.
    Communication Backend-Frontend :
        J'ai rencontré des difficultés pour comprendre comment envoyer les données du backend vers le frontend via les templates et les routes. J'ai finalement réussi en étudiant les exemples et la documentation.
    Relations ManyToOne et OneToMany :
        J'ai été bloqué pendant deux jours en raison de la confusion entre les relations ManyToOne et OneToMany. Après avoir pris le temps de revoir et de bien réfléchir, j'ai pu les implémenter correctement.
    Liaison entre Disponibilité et Véhicule :
        J'ai eu des difficultés à lier une disponibilité à un véhicule, notamment pour récupérer l'ID du véhicule lors de la création de disponibilités. Grâce au débogage avec xDebug, j'ai pu surmonter cette difficulté.
    Apprentissage du Débogage :
        J'ai appris à utiliser xDebug pour déboguer mon code, ce qui a été très bénéfique pour identifier et résoudre les problèmes.
    Centralisation des Services :
        Malheureusement, je n'ai pas réussi à utiliser les services pour centraliser certaines fonctionnalités comme prévu.

Débogage avec xDebug

Pour utiliser xDebug pour le débogage, assurez-vous que xDebug est correctement installé et configuré. Voici un exemple de configuration pour php.ini :
[xdebug]
zend_extension="xdebug.so"
xdebug.mode=debug
xdebug.start_with_request=yes
xdebug.client_host=127.0.0.1
xdebug.client_port=9003

Utilisation de PHPMyAdmin

Pour gérer votre base de données MySQL, vous pouvez utiliser PHPMyAdmin. Accédez à PHPMyAdmin via l'URL http://127.0.0.1:8080 (ou une autre URL en fonction de votre configuration WAMP/MAMP/LAMP). Connectez-vous avec les mêmes informations d'identification que celles définies dans votre fichier .env.local.
Conclusion

Ce projet permet de gérer les disponibilités et les tarifs de location des véhicules de manière efficace en utilisant Symfony. Suivez les étapes ci-dessus pour configurer et exécuter le projet. Pour toute question ou problème, n'hésitez pas à consulter la documentation Symfony ou à contacter notre équipe.


### Explications supplémentaires

- **Installation et Configuration** : La section d'installation guide l'utilisateur à travers les étapes nécessaires pour configurer l'environnement de développement et la base de données.
- **Utilisation** : La section d'utilisation explique comment utiliser les fonctionnalités principales de l'application.
- **Difficultés Rencontrées et Surmontées** : Détaille les défis rencontrés lors du développement du projet et comment ils ont été surmontés.
- **Débogage avec xDebug** : Fournit des instructions pour configurer xDebug, un outil essentiel pour le débogage en PHP.
- **PHPMyAdmin** : Guide sur l'utilisation de PHPMyAdmin pour gérer la base de données MySQL de manière graphique.

Assurez-vous de remplacer `<URL_DU_DEPOT>` et `<NOM_DU_DEPOT>` par les valeurs réelles correspondant à votre projet.
