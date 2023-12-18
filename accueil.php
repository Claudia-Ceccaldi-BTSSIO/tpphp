<?php
// Inclut le fichier de configuration de la base de données
require_once 'config.php';
// Inclut le fichier de gestion de session
require_once 'session.php';
// Inclut les classes Utilisateur et UtilisateurManager
require_once 'utilisateur.class.php';
require_once 'utilisateurManager.class.php';

// Vérifie si l'ID de l'utilisateur est enregistré dans la session
if (isset($_SESSION['utilisateur_id'])) {
    // Récupère l'ID de l'utilisateur
    $utilisateur_id = $_SESSION['utilisateur_id'];

    // Prépare et exécute la requête pour obtenir le nom d'utilisateur
    $query = $maconnexion->prepare("SELECT nom_utilisateur FROM Utilisateurs WHERE id = :id");
    $query->bindParam(':id', $utilisateur_id, PDO::PARAM_INT);
    $query->execute();

    // Récupère le résultat
    $row = $query->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $nom_utilisateur = $row['nom_utilisateur'];
    } else {
        $nom_utilisateur = "Utilisateur inconnu"; // Gestion si l'utilisateur n'est pas trouvé
    }
} else {
    // Rediriger vers la page de connexion si aucun utilisateur n'est connecté
    header("Location: connexion.php");
    exit;
}

// Initialisation de l'instance de UtilisateurManager avec la connexion PDO
$utilisateurManager = new UtilisateurManager($maconnexion);

// Initialisation des messages
$succesMessage = "";
$errorMessage = "";

// Traitement du formulaire d'ajout d'utilisateur
if (isset($_POST['nom_utilisateur']) && isset($_POST['motdepasse'])) {
    // Création d'un nouvel utilisateur
    $abonne = new Abonne($_POST['nom_utilisateur'], $_POST['motdepasse'], ""); 

    // Tentative d'ajout de l'utilisateur à la base de données
    try {
        $utilisateurManager->add($abonne);
        $succesMessage = "Nouvel utilisateur ajouté avec succès";
    } catch (Exception $e) {
        $errorMessage = "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
    }
}

// Récupération des utilisateurs pour affichage
$users = []; 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['afficher_utilisateurs'])) {
    $queryUtilisateurs = "SELECT * FROM Utilisateurs";
    $resultUtilisateurs = $maconnexion->query($queryUtilisateurs);
    $users = $resultUtilisateurs->fetchAll(PDO::FETCH_ASSOC);
}

// Préparation de la requête pour récupérer les commentaires
$queryCommentaires = "SELECT * FROM CommentairesLivres";
$stmtCommentaires = $maconnexion->prepare($queryCommentaires);
$stmtCommentaires->execute();

// Récupération des commentaires
$commentaires = $stmtCommentaires->fetchAll(PDO::FETCH_ASSOC);
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
<?php if (isset($nom_utilisateur)) : ?>
        <div class="user-greeting">
            Bonjour, <?php echo htmlspecialchars($nom_utilisateur); ?>
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

    <!-- Bouton pour afficher les utilisateurs -->
    <form method="post">
        <input type="submit" name="afficher_utilisateurs" value="Afficher les Utilisateurs">
    </form>

    <?php
     // Affichage des utilisateurs dans un tableau
     if (count($users) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nom d'utilisateur</th><th>Mot de passe</th><th>Région</th></tr>";
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($user['id']) . "</td>";
            echo "<td>" . htmlspecialchars($user['nom_utilisateur']) . "</td>";
            echo "<td>" . htmlspecialchars($user['motdepasse']) . "</td>";
            echo "<td>" . htmlspecialchars($user['user_region']) . "</td>"; 
            echo "</tr>";
        }
        echo "</table>";
    }
    ?>
    <section class="book-display">
        <!-- Livre 1 -->
        <article class="book">
            <img src="images/vent.jpg" alt="Couverture du livre 1">
            <h2>Vent d'Est , vent d'Ouest</h2>
            <p>Le livre Vent d’Est, vent d’Ouest de Pearl Buck raconte l’histoire de Kwei-Lan, une jeune fille chinoise qui vient d’être mariée à un homme de sa race qui revient d’Europe. Ce dernier a oublié la loi des ancêtres et ne respecte plus les coutumes ni les rites. Le frère de Kwei-Lan, qui est l’héritier mâle, annonce son mariage avec une étrangère. A travers les réactions 
                de cette famille, le roman aborde les thèmes de l’amour, de la tolérance et de l’apprentissage1</p>
            <div class="comment-section">
            <form action="traitement_commentaire.php" method="post">
            <input type="hidden" name="book_id" value="01"> 
            <textarea name="commentaire" placeholder="Votre commentaire"></textarea>
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
            <input type="hidden" name="book_id" value="ID_DU_LIVRE_1"> 
            <textarea name="commentaire" placeholder="Votre commentaire"></textarea>
            <input type="submit" value="Envoyer le commentaire">
            </form>
            </div>
        </article>

        <!-- Livre 3 -->
        <article class="book">
            <img src="images/dragon.jpg" alt="Couverture du livre 3">
            <h2>Le fils du dragon</h2>
            <p>Pearl Buck savait-elle, lorsqu'elle décrivit l'existence de cette famille de paysans 
                chinois, humbles et travailleurs, qu'elle annonçait prophétiquement l'immense évolution 
                de la Chine au cours de ces dernières années ? Lorsque Lao quitte, avec sa jeune femme,
                 la ferme de ses parents pour rejoindre l'armée de patriotes qui résiste à l'envahisseur,
                  devine-t-il que sa rupture avec des habitudes millénaires prélude à la formidable épopée
                   que nous avons connue depuis ? En tout cas, la missionnaire américaine qui, au risque 
                   de sa vie, protège les jeunes Chinoises des outrages de la soldatesque ennemie, 
                   sait que cet acte de charité chrétienne demeurera le seul titre de gloire de l'Occident dans une Chine qui va retrouver le sens de sa grandeur et de sa puissance.</p>
            <div class="comment-section">
            <form action="traitement_commentaire.php" method="post">
            <input type="hidden" name="book_id" value="ID_DU_LIVRE_1"> 
            <textarea name="commentaire" placeholder="Votre commentaire"></textarea>
            <input type="submit" value="Envoyer le commentaire">
            </form>
            </div>
        </article>
    </section>
    <!-- Affichage des commentaires -->
    <section class="comment-section">
        <h2>Commentaires sur les Livres :</h2>
        <?php
        if (count($commentaires) > 0) {
            echo "<ul>";
            foreach ($commentaires as $commentaire) {
                echo "<li>" . htmlspecialchars($commentaire['commentaire']) . "</li>";
            }
            echo "</ul>";
        } else {
            echo 'Aucun commentaire disponible.';
        }
        ?>
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
// Fermeture de la connexion à la base de données
$maconnexion = null;
?>
