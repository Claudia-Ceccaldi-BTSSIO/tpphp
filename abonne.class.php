<?php
require_once 'utilisateur.class.php';

// La classe Abonne étend la classe Utilisateur
class Abonne extends Utilisateur {
    // Constructeur de la classe Abonne
    public function __construct($nom, $mp, $ur) {
        parent::__construct($nom, $mp, $ur); // Appel au constructeur parent
    }

    // Définit le prix de l'abonnement en fonction de la région de l'utilisateur
    public function setPrixAbo() {
        if($this->user_region === 'Sud') {
            $this->prix_abo = Utilisateur::ABONNEMENT / 2; // Tarif réduit pour la région 'Sud'
        } else {
            $this->prix_abo = Utilisateur::ABONNEMENT; // Tarif standard
        }
    }

    // Obtient le nom d'utilisateur 
    public function getNom_utilisateur() {
        return $this->nom_utilisateur;
    }

    // Affiche le prix de l'abonnement
    public function getPrixAbo() {
        echo $this->prix_abo;
    }
}
?>
