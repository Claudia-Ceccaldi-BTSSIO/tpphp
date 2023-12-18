<?php
// Inclusion des fichiers de configuration et démarrage de la session
require_once 'config.php';
session_start();

// Initialisation des messages d'erreur
$errorMessage = "";

// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nom_utilisateur']) && isset($_POST['motdepasse'])) {
    // Récupération des données envoyées par l'utilisateur
    $nom_utilisateur = $_POST['nom_utilisateur'];
    $motdepasse = $_POST['motdepasse'];

    // Préparation de la requête SQL pour éviter les injections SQL
    $query = "SELECT id, motdepasse FROM Utilisateurs WHERE nom_utilisateur = :nom_utilisateur";
    $stmt = $maconnexion->prepare($query);
    $stmt->bindParam(':nom_utilisateur', $nom_utilisateur, PDO::PARAM_STR);
    $stmt->execute();

    // Vérification si l'utilisateur existe dans la base de données
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérification du mot de passe
        if (password_verify($motdepasse, $row['motdepasse'])) {
            // Si le mot de passe est correct, initialisation de la session
            $_SESSION['utilisateur_id'] = $row['id'];
            $_SESSION['nom_utilisateur'] = $nom_utilisateur;

            // Redirection vers la page d'accueil
            header("Location: accueil.php");
            exit;
        } else {
            // Si le mot de passe est incorrect, affichage d'un message d'erreur
            $errorMessage = "Connexion échouée";
        }
    } else {
        // Si l'utilisateur n'est pas trouvé, affichage d'un message d'erreur
        $errorMessage = "Utilisateur non trouvé";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de connexion</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <!-- Formulaire de connexion -->
    <form action="connexion.php" method="post">
        <label for="nom_utilisateur">Nom d'utilisateur: </label>
        <input type="text" name="nom_utilisateur" placeholder="" required>
        <label for="motdepasse">Mot de passe : </label>
        <input type="password" name="motdepasse" placeholder="" required>
        <input type="submit" value="Se connecter">
    </form>

    <!-- Affichage des messages d'erreur -->
    <?php if (!empty($errorMessage)) : ?>
        <p class="error"><?php echo $errorMessage; ?></p>
    <?php endif; ?>
</body>
</html>
