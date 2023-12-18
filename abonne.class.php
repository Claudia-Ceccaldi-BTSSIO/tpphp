<?php
require_once 'utilisateur.class.php';
require_once 'session.php';

// La classe Abonne étend la classe Utilisateur
class Abonne extends Utilisateur {
    // Constructeur de la classe Abonne
    public function __construct($nom, $mp, $ur) {
        parent::__construct($nom, $mp, $ur); // Appel au constructeur parent
        $this->setPrixAbo(); // Définit le prix de l'abonnement dès la création de l'objet
    }

    // Définit le prix de l'abonnement en fonction de la région de l'utilisateur
    protected function setPrixAbo() {
        // Utilisation de la méthode getUserRegion() pour accéder à la propriété protected user_region
        if($this->getUserRegion() === 'Sud') {
            $this->prix_abo = Utilisateur::ABONNEMENT / 2; // Tarif réduit pour la région 'Sud'
        } else {
            $this->prix_abo = Utilisateur::ABONNEMENT; // Tarif standard
        }
    }

    // Obtient le nom d'utilisateur en utilisant la méthode héritée de la classe parente
    public function getNomUtilisateur() {
        return parent::getNomUtilisateur();
    }

    // Affiche le prix de l'abonnement en utilisant la méthode getPrixAbo() héritée
    public function afficherPrixAbo() {
        echo $this->getPrixAbo();
    }
}
?>
