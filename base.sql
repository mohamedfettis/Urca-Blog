-- Création de la base de données
CREATE DATABASE IF NOT EXISTS blog;
USE blog;

-- Création de la table users
CREATE TABLE users (
    idu INT PRIMARY KEY AUTO_INCREMENT,
    lastname VARCHAR(50) NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    pwd VARCHAR(255) NOT NULL
);

-- Création de la table news
CREATE TABLE news (
    idn INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    image VARCHAR(255),
    author  VARCHAR(255) NOT NULL,
);