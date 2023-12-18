<?php
//Inclus la class Utilisateur
require_once 'utilisateur.class.php';

class Admin extends Utilisateur {
    protected static $bannir = []; // Liste statique des utilisateurs bannis

    // Constructeur : initialise les propriétés de l'instance avec des valeurs spécifiques pour Admin
    public function __construct($nom, $mp, $ur) {
        parent::__construct(strtoupper($nom), $mp, $ur); // Appel au constructeur parent avec le nom en majuscules
    }

    // Affiche le nom d'utilisateur (hérité, redéfini pour afficher en majuscules)
    public function getNom_utilisateur() {
        return $this->nom_utilisateur;
    }

    // Définit le prix de l'abonnement en fonction de la région
    public function setPrixAbo() {
        $this->prix_abo = $this->user_region === 'Sud' ? Utilisateur::ABONNEMENT / 6 : Utilisateur::ABONNEMENT / 3;
    }

    // Ajoute un utilisateur à la liste des bannis
    public function setBannir($utilisateur) {
        self::$bannir[] = $utilisateur;
    }

    // Affiche la liste des utilisateurs bannis
    public function getBannir() {
        echo 'Utilisateurs bannis par ' . $this->nom_utilisateur . ' : ' . implode(', ', self::$bannir);
    }
}
?>
