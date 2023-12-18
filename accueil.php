<?php
// Inclut le fichier de configuration de la base de données
require_once 'config.php';

// Message de succès lorsqu'un nouvel utilisateur est ajouté
$succesMessage = "";
$errorMessage = "";

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

// Récupére les utilisateurs depuis la base de données
$queryUtilisateurs = "SELECT * FROM Utilisateurs";
$resultUtilisateurs = $connexion->query($queryUtilisateurs);

// Récupére les commentaires depuis la base de données
$queryCommentaires = "SELECT * FROM Commentaires";
$resultCommentaires = $connexion->query($queryCommentaires);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <!-- Formulaire d'ajout d'utilisateur -->
    <h2>Ajouter un nouvel utilisateur</h2>
    <form action="accueil.php" method="post">
        <label for="nom_utilisateur">Nom d'utilisateur : </label>
        <input type="text" name="nom_utilisateur" placeholder="Nom d'utilisateur" required>
        <label for="motdepasse">Mot de passe : </label>
        <input type="password" name="motdepasse" placeholder="Mot de passe" required>
        <input type="submit" value="Ajouter">
    </form>
    <!-- Message de succès pour l'ajout d'un nouvel utilisateur -->
    <?php if (!empty($succesMessage)) : ?>
        <p class="success"><?php echo $succesMessage; ?></p>
    <?php endif; ?>
    <!-- Message d'erreur en cas d'échec de l'ajout -->
    <?php if (!empty($errorMessage)) : ?>
        <p class="error"><?php echo $errorMessage; ?></p>
    <?php endif; ?>

    <!-- Affichage des utilisateurs -->
    <h2>Liste des utilisateurs</h2>
    <ul>
        <?php while ($rowUtilisateur = $resultUtilisateurs->fetch_assoc()) : ?>
            <li><?php echo $rowUtilisateur['nom_utilisateur']; ?></li>
        <?php endwhile; ?>
    </ul>

    <!-- Formulaire pour récupérer les commentaires et la région de l'utilisateur -->
    <h2>Votre région</h2>
    <form action="traitement_commentaires.php" method="post">
        <label for="region">Région : </label>
        <input type="text" name="region" placeholder="Entrez votre région" required>
        
        <h2>Vos commentaires</h2>
        <label for="commentaires">Commentaires : </label>
        <textarea name="commentaires" placeholder="Entrez vos commentaires ici"></textarea>

        <input type="submit" value="Envoyer">
    </form>

    <!-- Affichage des commentaires -->
    <h2>Commentaires des utilisateurs</h2>
    <?php if ($resultCommentaires->num_rows > 0) : ?>
        <ul>
            <?php while ($rowCommentaire = $resultCommentaires->fetch_assoc()) : ?>
                <li>
                    <p>Région : <?php echo $rowCommentaire['region']; ?></p>
                    <p>Commentaire : <?php echo $rowCommentaire['commentaire']; ?></p>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else : ?>
        <p>Aucun commentaire trouvé.</p>
    <?php endif; ?>

</body>
</html>

<?php
// Ferme les résultats des requêtes
$resultUtilisateurs->close();
$resultCommentaires->close();

// Ferme la connexion à la base de données 
$connexion->close();
?>
