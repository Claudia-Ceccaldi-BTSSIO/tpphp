<?php
// Inclut le fichier de configuration de la base de données
require_once 'config.php';
require_once 'session.php';
session_start();
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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librairie en Ligne</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
<?php if (isset($_SESSION['utilisateur_id'])) : ?>
    <div class="user-greeting">
        Bonjour, <?php echo htmlspecialchars($_SESSION['utilisateur_id']); ?>
    </div>
<?php endif; ?>

    <style>
body {
    background-color: #f0f4f8;
    color: #333;
    font-family: 'Helvetica Neue', Arial, sans-serif;
    text-align: center;
}

header {
    background-color: #a7c7e7;
    color: #333;
    padding: 15px 0;
}

.book-display {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    padding: 20px;
}

.book {
    background-color: #e7eff6;
    border: 1px solid #d0dae3;
    color: #333;
    margin: 10px;
    padding: 20px;
    width: 300px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.book img {
    max-width: 100%;
    height: auto;
    margin-bottom: 15px;
}

.comment-section {
    background-color: #d3d3d3;
    padding: 10px;
    margin-top: 15px;
}

footer {
    background-color: #a7c7e7;
    color: #333;
    padding: 15px 0;
}
</style>
    <header>
        <h1>Bienvenue dans Notre Librairie</h1>
    </header>

    <section class="book-display">
        <!-- Livre 1 -->
        <article class="book">
            <img src="images/vent.jpg" alt="Couverture du livre 1">
            <h2>Vent d'Est , vent d'Ouest</h2>
            <p>Le livre Vent d’Est, vent d’Ouest de Pearl Buck raconte l’histoire de Kwei-Lan, une jeune fille chinoise qui vient d’être mariée à un homme de sa race qui revient d’Europe. Ce dernier a oublié la loi des ancêtres et ne respecte plus les coutumes ni les rites. Le frère de Kwei-Lan, qui est l’héritier mâle, annonce son mariage avec une étrangère. A travers les réactions 
                de cette famille, le roman aborde les thèmes de l’amour, de la tolérance et de l’apprentissage1</p>
            <div class="comment-section">
            <form action="traitement_commentaire.php" method="post">
            <input type="hidden" name="book_id" value="01"> <!-- Remplacer par l'ID réel du livre -->
            <textarea name="comment" placeholder="Votre commentaire"></textarea>
            <input type="submit" value="Envoyer le commentaire">
        </form>
            </div>
        </article>

        <!-- Livre 2 -->
        <article class="book">
            <img src="images/terre.jpg" alt="Couverture du livre 2">
            <h2>La terre chinoise</h2>
            <p>Ce roman raconte l’histoire de Wang Lung, un agriculteur chinois qui vit dans un village avant la Première Guerre mondiale. Le récit suit sa vie de famille et les épreuves qu’il traverse pour acquérir une fortune considérable. 
                Le livre a été publié en 1931 et a remporté le Prix Pulitzer de la fiction en 1932.</p>
            <div class="comment-section">
            <form action="traitement_commentaire.php" method="post">
            <input type="hidden" name="book_id" value="ID_DU_LIVRE_1"> <!-- Remplacer par l'ID réel du livre -->
            <textarea name="comment" placeholder="Votre commentaire"></textarea>
            <input type="submit" value="Envoyer le commentaire">
            </form>
            </div>
        </article>

        <!-- Livre 3 -->
        <article class="book">
            <img src="images/dragon.jpg" alt="Couverture du livre 3">
            <h2>Le fils du dragon</h2>
            <p></p>
            <div class="comment-section">
            <form action="traitement_commentaire.php" method="post">
            <input type="hidden" name="book_id" value="ID_DU_LIVRE_1"> <!-- Remplacer par l'ID réel du livre -->
            <textarea name="comment" placeholder="Votre commentaire"></textarea>
            <input type="submit" value="Envoyer le commentaire">
            </form>
            </div>
        </article>
    </section>
    <nav>
        <!-- lien déconnexion -->
        <a href="logout.php">Déconnexion</a>
    </nav>
    <footer>
        <p>&copy; 2023 Librairie en Ligne</p>
    </footer>
</body>
</html>

<?php
// Ferme les résultats des requêtes
$resultUtilisateurs->close();

// Ferme la connexion à la base de données 
$connexion->close();
?>
