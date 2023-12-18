-- Création de la table des utilisateurs
CREATE TABLE Utilisateurs (
    id INT PRIMARY KEY AUTO_INCREMENT,              -- Identifiant unique pour chaque utilisateur
    nom_utilisateur VARCHAR(255) UNIQUE NOT NULL,   -- Nom d'utilisateur unique
    motdepasse VARCHAR(255) NOT NULL,               -- Mot de passe (stocké comme hash)
    prix_abo DECIMAL(10, 2),                        -- Prix de l'abonnement
    user_region VARCHAR(50)                         -- Région de l'utilisateur
);

-- Table des administrateurs
CREATE TABLE Admins (
    id INT PRIMARY KEY AUTO_INCREMENT,
    utilisateur_id INT,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateurs(id)
);

-- Table des utilisateurs bannis
CREATE TABLE Bannis (
    id INT PRIMARY KEY AUTO_INCREMENT,
    admin_id INT,
    utilisateur_id INT,
    FOREIGN KEY (admin_id) REFERENCES Admins(id),
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateurs(id)
);

-- Table des commentaires des livres
CREATE TABLE CommentairesLivres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    livre_id INT,
    utilisateur_id INT,
    commentaire TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (livre_id) REFERENCES Livres(id),
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateurs(id)
);

CREATE TABLE Livres (
    id INT PRIMARY KEY AUTO_INCREMENT,        -- Identifiant unique pour chaque livre
    titre VARCHAR(255) NOT NULL,             -- Titre du livre
    auteur VARCHAR(255) NOT NULL,            -- Auteur du livre
    description TEXT,                        -- Description ou résumé du livre
    date_publication DATE,                   -- Date de publication
    image_couverture VARCHAR(255),           -- Chemin vers l'image de couverture du livre
    prix DECIMAL(10, 2)                      -- Prix du livre
);

