<?php
// Classe abstraite Utilisateur : Base pour les classes dérivées d'utilisateurs.
abstract class Utilisateur {
    protected $nom_utilisateur;   
    protected $motdepasse;       
    protected $user_region;      
    protected $prix_abo;          

    // Constante publique pour un prix d'abonnement de base.
    public const ABONNEMENT = 15;

    // Constructeur : initialisation des propriétés de l'instance avec une boucle foreach.
    public function __construct($nom_utilisateur, $motdepasse, $user_region) {
        
        // Le tableau associatif contient les méthodes 'set' en tant que clés et les valeurs à assigner en tant que valeurs.
        $props = [
            'setNomUtilisateur' => $nom_utilisateur,
            'setMotdepasse' => $motdepasse,
            'setUserRegion' => $user_region,
        ];
        // Utilisation d'une boucle foreach pour assigner les valeurs.
        foreach ($props as $method => $value) {
            if (method_exists($this, $method)) {
                $this->$method($value); // Appel dynamique de la méthode 'set'.
            }
        }
    }

    // Méthodes 'set' pour chaque propriété.
    protected function setNomUtilisateur($value) {
        $this->nom_utilisateur = $value;
    }

    protected function setMotdepasse($value) {
        $this->motdepasse = password_hash($value, PASSWORD_DEFAULT);
    }

    protected function setUserRegion($value) {
        $this->user_region = $value;
    }

    // Méthode abstraite : doit être définie dans les classes dérivées.
    abstract protected function setPrixAbo();

    // Méthodes 'get' pour accéder aux propriétés.
    public function getNomUtilisateur() {
        return $this->nom_utilisateur;
    }

    public function getMotdepasse() {
        return $this->motdepasse;
    }

    public function getUserRegion() {
        return $this->user_region;
    }

    public function getPrixAbo() {
        return $this->prix_abo;
    }


    public function __toString() {
        return "Nom d'utilisateur: " . $this->nom_utilisateur . ", Région: " . $this->user_region . ", Prix Abonnement: " . $this->prix_abo;
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
            background-color: #000; 
            color: #fff; 
        }
        /* Style pour les messages de succès et d'erreur */
        .success {
            color: #00f; 
        }
        .error {
            color: #f00; 
        }
    </style>
</body>
</html>
