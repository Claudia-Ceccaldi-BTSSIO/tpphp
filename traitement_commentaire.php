<?php
// Inclus le fichier de configuration de la base de données
require_once 'config.php';
require_once 'session.php';

// Récupère les données du formulaire
$utilisateur_id = $_SESSION['utilisateur_id']; // Assurez-vous que cet ID est bien défini dans la session
$commentaire = $_POST['commentaires']; // Récupération du commentaire

// Préparation de la requête d'insertion
$query = "INSERT INTO Commentaires (utilisateur_id, commentaire) VALUES (?, ?)";
$stmt = $connexion->prepare($query);
$stmt->bind_param("is", $utilisateur_id, $commentaire);

//Vérification de utilisateur_id bien défini
if (isset($_SESSION['utilisateur_id'])) {
    $utilisateur_id = $_SESSION['utilisateur_id'];
    // Le reste de votre script
} else {
    // Rediriger vers la page de connexion ou afficher un message d'erreur
    header("Location: connexion.php");
    exit;
}

// Exécution de la requête préparée
if ($stmt->execute()) {
    // Commentaire enregistré avec succès
    header("Location: accueil.php"); // Rediriger l'utilisateur vers la page d'accueil
} else {
    // Échec de l'enregistrement du commentaire
    echo 'Échec de l\'enregistrement du commentaire : ' . $stmt->error;
}

$stmt->close();
$connexion->close();
?>
