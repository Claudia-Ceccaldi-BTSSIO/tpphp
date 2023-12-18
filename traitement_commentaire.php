<?php
// Inclus le fichier de configuration de la base de données
require_once 'config.php';
require_once 'session.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    // Si l'utilisateur n'est pas connecté, redirige vers la page de connexion
    header("Location: connexion.php");
    exit;
}

// Récupère l'ID de l'utilisateur depuis la session
$utilisateur_id = $_SESSION['utilisateur_id'];

// Récupère les données du formulaire
if (isset($_POST['commentaire'])) {
    $commentaire = $_POST['commentaire']; 

    // Préparation de la requête d'insertion avec PDO
    $query = "INSERT INTO CommentairesLivres (utilisateur_id, commentaire) VALUES (:utilisateur_id, :commentaire)";
    $stmt = $maconnexion->prepare($query);

    // Liaison des paramètres
    $stmt->bindParam(":utilisateur_id", $utilisateur_id, PDO::PARAM_INT);
    $stmt->bindParam(":commentaire", $commentaire, PDO::PARAM_STR);

    // Exécution de la requête préparée
    if ($stmt->execute()) {
        // Commentaire enregistré avec succès, redirection vers la page d'accueil
        header("Location: accueil.php");
    } else {
        // Échec de l'enregistrement du commentaire
        echo 'Échec de l\'enregistrement du commentaire';
    }
} else {
    // si aucun commentaire fourni, redirection vers la page d'accueil
    header("Location: accueil.php");
}
?>
