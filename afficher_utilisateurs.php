<?php
// Inclut le fichier de connexion à la base de données
require_once 'config.php';
require_once 'session.php';
// Requête SQL pour récupérer tous les utilisateurs
$query = "SELECT nom_utilisateur FROM Utilisateurs";
$result = $connexion->query($query);

if ($result->num_rows > 0) {
    echo '<h2>Liste des utilisateurs :</h2>';
    echo '<ul>';
    while ($row = $result->fetch_assoc()) {
        echo '<li>' . $row['nom_utilisateur'] . '</li>';
    }
    echo '</ul>';
} else {
    echo 'Aucun utilisateur enregistré.';
}

$connexion->close();
?>
