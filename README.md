Projet TP02 - Blog - Partie Actualités

# 📌  Description du Projet

Ce projet consiste à développer un blog permettant la gestion des actualités et des utilisateurs. Il inclut la création, la modification, la suppression et l'affichage des actualités, ainsi que la gestion des utilisateurs via un système d'inscription, de connexion et de déconnexion.

# 📁  Structure du Projet

Le projet est organisé en plusieurs répertoires :

config/ : Contient les fichiers de configuration de la base de données.

users/ : Contient les fichiers pour la gestion des utilisateurs.

news/ : Contient les fichiers pour la gestion des actualités.

img/ : Contient les images associées aux actualités.

index.php : Page d'accueil du site.

# 🗄️  Base de Données

Tables

# 📌Table news

Champ

Type

Description

idn

INT (PK)

Identifiant unique de l'actualité

title

VARCHAR(255)

Titre de l'actualité

content

TEXT

Contenu de l'actualité

author

INT (FK)

Identifiant de l'auteur

date

DATETIME

Date de publication

image

VARCHAR(255)

URL de l'image associée

# 📌 Table users

Champ

Type

Description

idu

INT (PK)

Identifiant unique de l'utilisateur

lastname

VARCHAR(100)

Nom de l'utilisateur

firstname

VARCHAR(100)

Prénom de l'utilisateur

email

VARCHAR(255)

Email (doit être unique)

pwd

VARCHAR(255)

Mot de passe haché

# 🔧Fonctionnalités

Gestion des Actualités

news-add.php : Permet l'ajout d'une actualité (accessible uniquement aux utilisateurs connectés).

news-list.php : Affiche la liste des actualités classées de la plus récente à la plus ancienne.

news-view.php : Affiche le détail d'une actualité.

news-remove.php : Permet la suppression d'une actualité (uniquement par son auteur).

news-modif.php : Permet la modification d'une actualité (uniquement par son auteur).

Gestion des Utilisateurs

registration.php :

Inscription d'un nouvel utilisateur.

Validation du courriel et du mot de passe avec confirmation.

Empêche la création d'un utilisateur avec un email déjà existant.

user-profil.php :

Visualisation et modification des informations du profil.

Modification du courriel et du mot de passe avec confirmation.

Connexion / Déconnexion

connect.php :

Page de connexion avec email et mot de passe.

Si les informations sont valides, ouverture d'une session et redirection vers une page privée.

private.php :

Page accessible uniquement aux utilisateurs connectés.

Affiche le nom et le prénom de l'utilisateur connecté.

disconnect.php :

Fermeture de la session et redirection vers l'accueil.

Page d'Accueil

index.php :

Menu permettant d'accéder à l'inscription, la connexion et la liste des actualités.

# 🔑 Règles d'Accès et Automatisations

La page d'ajout d'une actualité est réservée aux utilisateurs connectés.

Lors de l'ajout d'une actualité :

L'auteur est automatiquement renseigné avec l'ID de l'utilisateur connecté.

La date est initialisée à la date du jour.

Les boutons de modification et de suppression d'une actualité ne sont visibles que pour son auteur.

🚀 # Installation

Prérequis

Serveur web (Apache, Nginx, etc.)

PHP 7.4+

MySQL / MariaDB

PhpMyAdmin (optionnel)

Configuration

Importer la base de données :

Exécuter le fichier blog.sql (fournissant la structure des tables) dans PhpMyAdmin.

Configurer la base de données :

Modifier le fichier config/database.php avec vos identifiants MySQL.

Démarrer le serveur :

Utiliser php -S localhost:8000 pour tester en local.

# 👤 Auteur

Nom : Mohamed Amokrane Fettis
