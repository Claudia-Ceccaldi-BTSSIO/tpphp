<?php
// Inclus la classe Utilisateur et le gestionnaire de session
require_once 'utilisateur.class.php';
require_once 'session.php';

// La classe Admin étend la classe Utilisateur
class Admin extends Utilisateur {
    protected static $bannir = []; // Liste statique des utilisateurs bannis

    // Constructeur : initialise les propriétés de l'instance avec des valeurs spécifiques pour Admin
    public function __construct($nom_utilisateur, $motdepasse, $user_region) {
        // Appel au constructeur parent avec le nom en majuscules
        parent::__construct(strtoupper($nom_utilisateur), $motdepasse, $user_region);
        $this->setPrixAbo(); // Définit le prix de l'abonnement dès la création de l'objet
    }

    // Définit le prix de l'abonnement en fonction de la région
    protected function setPrixAbo() {
        // Utilisation de la méthode getUserRegion() pour accéder à la propriété protected user_region
        $this->prix_abo = $this->getUserRegion() === 'Sud' ? Utilisateur::ABONNEMENT / 6 : Utilisateur::ABONNEMENT / 3;
    }

    // Obtient le nom d'utilisateur en utilisant la méthode héritée de la classe parente
    public function getNomUtilisateur() {
        return parent::getNomUtilisateur();
    }

    // Ajoute un utilisateur à la liste des bannis
    public function setBannir($utilisateur) {
        self::$bannir[] = $utilisateur;
    }

    // Affiche la liste des utilisateurs bannis
    public function getBannir() {
        echo 'Utilisateurs bannis par ' . $this->getNomUtilisateur() . ' : ' . implode(', ', self::$bannir);
    }
}
?>
