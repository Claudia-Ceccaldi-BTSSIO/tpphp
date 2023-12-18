<?php
// Inclut le fichier de connexion à la base de données et démarre la session
require_once 'config.php';
session_start(); 

// Message de succès lorsqu'un nouvel utilisateur est ajouté
$succesMessage = "";
$errorMessage = "";

// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nom_utilisateur']) && isset($_POST['motdepasse'])) {
    $nom_inscription = $connexion->real_escape_string($_POST['nom_utilisateur']);
    $mp_inscription = $_POST['motdepasse'];
    // Vérification des informations soumises par les utilisateurs contre celles de la base de données
    $query = "SELECT id, motdepasse FROM Utilisateurs WHERE nom_utilisateur = '$nom_inscription'";
    $result = $connexion->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($mp_inscription, $row['motdepasse'])) {
            // Connexion réussie
            $_SESSION['utilisateur_id'] = $row['id']; // Stocker l'ID de l'utilisateur dans la session
            $_SESSION['utilisateur_id'] = $nom_inscription; // Stocker le nom d'utilisateur dans la session

            // Redirection vers la page d'accueil
            header("Location: accueil.php");
            exit;
        } else {
            // Échec de la connexion
            $errorMessage = "Connexion échouée";
        }
    } else {
        // Utilisateur non trouvé
        $errorMessage = "Utilisateur non trouvé";
    }
}

// Le reste de votre code...
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
    <form action="accueil.php" method="post">
        <!-- Connexion -->
        <label for="nom_utilisateur">Nom d'utilisateur: </label>
        <input type="text" name="nom_utilisateur" placeholder="" required>
        <label for="motdepasse">Mot de passe : </label>
        <input type="password" name="motdepasse" placeholder="" required>
        <input type="submit" value="Se connecter">
    </form>
    
    <!-- Message de succès pour l'ajout d'un nouvel utilisateur -->
    <?php if (!empty($succesMessage)) : ?>
        <p class="success"><?php echo $succesMessage; ?></p>
    <?php endif; ?>

    <!-- Message d'erreur en cas de connexion échouée -->
    <?php if (!empty($errorMessage)) : ?>
        <p class="error"><?php echo $errorMessage; ?></p>
    <?php endif; ?>
</body>
</html>
