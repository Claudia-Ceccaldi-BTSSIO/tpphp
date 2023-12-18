-- Création de la table des utilisateurs
CREATE TABLE Utilisateurs (
    id INT PRIMARY KEY AUTO_INCREMENT,              -- Identifiant unique pour chaque utilisateur
    nom_utilisateur VARCHAR(255) UNIQUE NOT NULL,   -- Nom d'utilisateur unique
    motdepasse VARCHAR(255) NOT NULL,               -- Mot de passe (stocké comme hash)
    prix_abo DECIMAL(10, 2),                        -- Prix de l'abonnement
    user_region VARCHAR(50)                         -- Région de l'utilisateur
);

-- Création de la table des administrateurs
CREATE TABLE Admins (
    id INT PRIMARY KEY AUTO_INCREMENT,              -- Identifiant unique pour chaque administrateur
    utilisateur_id INT,                             -- Identifiant de l'utilisateur associé à l'administrateur
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateurs(id)  -- Lien vers la table des utilisateurs
);

-- Création de la table des utilisateurs bannis
CREATE TABLE Bannis (
    id INT PRIMARY KEY AUTO_INCREMENT,              -- Identifiant unique pour chaque bannissement
    admin_id INT,                                   -- Identifiant de l'administrateur qui a banni l'utilisateur
    utilisateur_banni_id INT,                       -- Identifiant de l'utilisateur banni
    FOREIGN KEY (admin_id) REFERENCES Admins(id),             -- Lien vers la table des administrateurs
    FOREIGN KEY (utilisateur_banni_id) REFERENCES Utilisateurs(id)  -- Lien vers la table des utilisateurs
);
CREATE TABLE Commentaires (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT, -- Clé étrangère vers la table Utilisateurs
    region VARCHAR(255),
    commentaire TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
