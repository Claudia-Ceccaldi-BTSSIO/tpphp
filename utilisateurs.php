<?php
// Inclut la configuration de la base de données et les classes
require_once 'config.php'; 
require_once 'utilisateur.class.php';
require_once 'abonne.class.php';
require_once 'admin.class.php';

// Création d'instances d'abonnés et d'administrateurs
$goku = new Abonne('Goku', 'chichi47', 'Sud');
$gohan = new Abonne('Gohan', 'videl666', 'Nord');
$vegeta = new Admin('Vegeta', 'bulma80', 'Est');
$bulma = new Admin('Bulma', 'trunks', 'Sud');

// Compilation d'une liste des utilisateurs pour l'insertion
$utilisateurs_insert = [$goku, $gohan, $vegeta, $bulma]; 

// Préparation de la requête SQL pour insérer des utilisateurs
$sql = $connexion->prepare("INSERT INTO Utilisateurs (nom_utilisateur, motdepasse, user_region, prix_abo) VALUES (?, ?, ?, ?)");

// Insertion de chaque utilisateur dans la base de données
foreach ($utilisateurs_insert as $utilisateur) {
    $nom_utilisateur = $utilisateur->getNom_utilisateur();
    $motdepasse = $utilisateur->getMotDePasse(); 

    $sql->bind_param("ssss", $nom_utilisateur, $motdepasse, $user_region, $prix_abo);
    
    // Exécution de la requête et gestion des résultats
    if ($sql->execute()) {
        echo "Utilisateur $nom_utilisateur ajouté avec succès.<br>";
    } else {
        echo "Erreur lors de l'ajout de l'utilisateur $nom_utilisateur : " . $sql->error . "<br>";
    }
}

// Fermeture de la requête préparée et de la connexion
$sql->close();
$connexion->close();

// Affichage des utilisateurs avec un formatage amélioré
echo '<table>';
echo '<tr><th>Nom d\'utilisateur</th><th>Région</th><th>Prix Abonnement</th></tr>';
foreach ($utilisateurs_insert as $utilisateur) {
    $utilisateur->setPrixAbo();
    $nom_utilisateur = $utilisateur->getNom_utilisateur();
    $region = $utilisateur->getUserRegion();
    $prix_abo = $utilisateur->getPrixAbo();

    echo '<tr>';
    echo '<td>' . $nom_utilisateur . '</td>';
    echo '<td>' . $region . '</td>';
    echo '<td>' . $prix_abo . '</td>';
    echo '</tr>';
}
echo '</table>';
?>
