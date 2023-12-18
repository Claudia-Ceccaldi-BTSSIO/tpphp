<?php
// Inclut le fichier de connexion à la base de données
require_once 'config.php';

// Message de succès lorsqu'un nouvel utilisateur est ajouté
$succesMessage = "";
$errorMessage = "";

// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_inscription = $connexion->real_escape_string($_POST['nom_utilisateur']);
    $mp_inscription = $_POST['motdepasse'];
    // Vérification des informations soumises par les utilisateurs contre celles de la base de données
    $query = "SELECT motdepasse FROM Utilisateurs WHERE nom_utilisateur = '$nom_inscription'";
    $result = $connexion->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($mp_inscription, $row['motdepasse'])) {
            // Connexion réussie
            // Utilise JavaScript pour rediriger vers la page d'accueil
            echo '<script>window.location.href = "accueil.php";</script>';
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

// Traitement du formulaire d'ajout d'utilisateur
if (isset($_POST['nom_utilisateur']) && isset($_POST['motdepasse'])) {
    $nom_utilisateur = $connexion->real_escape_string($_POST['nom_utilisateur']);
    $motdepasse = password_hash($_POST['motdepasse'], PASSWORD_DEFAULT);

    // Insertion de l'utilisateur dans la base de données en utilisant une requête préparée
    $stmt = $connexion->prepare("INSERT INTO Utilisateurs (nom_utilisateur, motdepasse) VALUES (?, ?)");
    $stmt->bind_param("ss", $nom_utilisateur, $motdepasse);

    if ($stmt->execute()) {
        // Inscription réussie
        $succesMessage = "Nouvel utilisateur ajouté avec succès";
    } else {
        // Échec de l'inscription
        $errorMessage = "Échec de l'inscription : " . $stmt->error;
    }
    $stmt->close();
}

$connexion->close();
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
    <form action="connexion.php" method="post">
        <!-- Connexion -->
        <label for="nom_utilisateur">Nom d'utilisateur: </label>
        <input type="text" name="nom_utilisateur" placeholder="Nom d'utilisateur" required>
        <label for="motdepasse">Mot de passe : </label>
        <input type="password" name="motdepasse" placeholder="Mot de passe" required>
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
