<?php
// Classe abstraite Utilisateur : Base pour les classes dérivées d'utilisateurs.
abstract class Utilisateur {
    // Propriétés protégées : accessibles uniquement dans la classe et les classes dérivées.
    protected $nom_utilisateur;   
    protected $motdepasse;       
    protected $user_region;      
    protected $prix_abo;          

    // Constante publique pour un prix d'abonnement de base.
    public const ABONNEMENT = 15;

    // Constructeur : initialisation des propriétés de l'instance.
    public function __construct($nom, $mp, $ur){
        $this->nom_utilisateur = $nom; 
        $this->motdepasse = password_hash($mp, PASSWORD_DEFAULT); // Hache le mot de passe
        $this->user_region = $ur; 
    }

    // Méthode abstraite : doit être définie dans les classes dérivées.
    abstract public function setPrixAbo();

    // Retourne le nom d'utilisateur.
    public function getNom_utilisateur(){
        echo $this->nom_utilisateur;
    }

    // Affiche le prix de l'abonnement.
    public function getPrixAbo(){
        echo $this->prix_abo;
    }
    public function __toString() {
        return "Nom d'utilisateur: " . $this->nom_utilisateur . ", Région: " . $this->user_region . ", Prix Abonnement: " . $this->prix_abo;
    }
    // Méthode pour obtenir le mot de passe 
    public function getMotDePasse() {
        return $this->motdepasse; // Retourne le mot de passe haché
    }
    // Méthode pour obtenir la région de l'utilisateur
    public function getUserRegion() {
    return $this->user_region;
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Utilisateurs</title>
</head>
<body>
<style>
        
        body {
            background-color: #000; /* Fond noir */
            color: #fff; /* Texte blanc */
        }
        /* Style pour les messages de succès et d'erreur */
        .success {
            color: #00f; /* Bleu */
        }
        .error {
            color: #f00; /* Rouge */
        }
    </style>
</body>
</html>
