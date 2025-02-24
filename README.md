# URCA Blog - Plateforme d'Actualités Universitaires

## 📌 Description

URCA Blog est une plateforme moderne de gestion d'actualités pour l'Université de Reims Champagne-Ardenne. Conçue avec une interface utilisateur élégante utilisant Tailwind CSS, elle permet la publication et la gestion d'articles, ainsi qu'un système complet d'authentification des utilisateurs.

## ✨ Fonctionnalités Principales

### Gestion des Articles
- Création d'articles avec images
- Modification et suppression d'articles
- Affichage responsive des articles
- Système de navigation intuitif

### Gestion des Utilisateurs
- Inscription avec validation des données
- Connexion sécurisée
- Profil utilisateur personnalisable
- Gestion des droits d'accès

### Interface Utilisateur
- Design moderne avec Tailwind CSS
- Navigation responsive
- Animations et transitions fluides
- Thème aux couleurs de l'URCA

## 📁 Structure du Projet

```
urca/
├── config/           # Configuration de la base de données
├── includes/         # Éléments réutilisables (header, footer)
├── users/            # Gestion des utilisateurs
│   ├── login.php
│   ├── registration.php
│   ├── user-profil.php
│   └── disconnect.php
├── news/             # Gestion des actualités
│   ├── news-add.php
│   ├── news-list.php
│   ├── news-modif.php
│   └── news-view.php
├── img/              # Images des articles
├── src/              # Ressources statiques
└── index.php         # Page d'accueil
```

## 🗄️ Structure de la Base de Données

### Table `news`

| Champ | Type | Description |
|-------|------|-------------|
| idn | INT (PK) | Identifiant unique de l'actualité |
| title | VARCHAR(255) | Titre de l'actualité |
| content | TEXT | Contenu de l'actualité |
| author | INT (FK) | Identifiant de l'auteur |
| date | DATETIME | Date de publication |
| image | VARCHAR(255) | Nom du fichier image |

### Table `users`

| Champ | Type | Description |
|-------|------|-------------|
| idu | INT (PK) | Identifiant unique de l'utilisateur |
| lastname | VARCHAR(100) | Nom de l'utilisateur |
| firstname | VARCHAR(100) | Prénom de l'utilisateur |
| email | VARCHAR(255) | Email (unique) |
| pwd | VARCHAR(255) | Mot de passe hashé |

## 🔗 Technologies Utilisées

- **Frontend**:
  - HTML5
  - Tailwind CSS
  - JavaScript
  - Font Awesome Icons

- **Backend**:
  - PHP
  - MySQL

## 💻 Installation

1. Cloner le repository
2. Configurer votre serveur web (Apache/XAMPP)
3. Créer la base de données et importer le schéma
4. Configurer le fichier `config/database.php`
5. Accéder au site via votre navigateur

## 🔒 Sécurité

- Protection contre les injections SQL
- Hashage des mots de passe
- Validation des données utilisateur
- Protection CSRF
- Sessions sécurisées

## 📈 Fonctionnalités à Venir

- [ ] Système de commentaires
- [ ] Catégorisation des articles
- [ ] Recherche avancée
- [ ] Système de notifications
- [ ] Intégration des réseaux sociaux

## 📝 Auteurs

- Mohamed FETTIS

## 📄 Licence

Ce projet est la propriété de l'Université de Reims Champagne-Ardenne (URCA).
