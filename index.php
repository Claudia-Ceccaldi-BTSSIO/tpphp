<?php
// Inclut le fichier de configuration de la base de données
require_once 'config.php';

// Définition des variables
$nom_inscription = "";
$mp_inscription = "";
$succesMessage = "";
$errorMessage = ""; 

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $nom_inscription = $_POST['nom_utilisateur'];
    $mp_inscription = password_hash($_POST['motdepasse'], PASSWORD_DEFAULT);
    $region_inscription = $_POST['region'];

    // Préparation de la requête d'insertion
    $query = $maconnexion->prepare('INSERT INTO Utilisateurs (nom_utilisateur, motdepasse, user_region) VALUES (:nom_utilisateur, :motdepasse, :region)');
    
    // Liaison des paramètres
    $query->bindParam(':nom_utilisateur', $nom_inscription, PDO::PARAM_STR);
    $query->bindParam(':motdepasse', $mp_inscription, PDO::PARAM_STR);
    $query->bindParam(':region', $region_inscription, PDO::PARAM_STR);
    
    // Exécution de la requête préparée
    if ($query->execute()) {
        $succesMessage = 'Inscription réussie';
        header("Location: connexion.php");
        exit;
    } else {
        // Récupération et affichage du message d'erreur de la base de données
        $errorInfo = $maconnexion->errorInfo();
        $errorMessage = 'Échec de l\'inscription : ' . $errorInfo[2];
    }
}
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
<style>
body {
    background-color: black;
    color: #333; 
    font-family: 'Helvetica Neue', Arial, sans-serif;
}

header {
    background-color: #a7c7e7; 
    color: #333;
    padding: 15px 0;
    text-align: center;
}

header h1 {
    margin: 0;
    font-weight: normal;
}
.book-display {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
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

footer {
    background-color: #a7c7e7;
    color: #333;
    text-align: center;
    padding: 15px 0;
}
.btn_conn {
    display: block; 
    margin: 0 auto; 
}
.center-container{
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    align-items: center;
    width: 92%;
    text-align: center;
}
</style>

   <!-- Formulaire d'inscription -->
<form action="index.php" method="post">
    <label for="nom_utilisateur">Nom d'utilisateur : </label>
    <input type="text" name="nom_utilisateur" placeholder="Nom d'utilisateur" required>
    <label for="motdepasse">Mot de passe : </label>
    <input type="password" name="motdepasse" placeholder="Mot de passe" required>
    <label for="region">Région : </label>
    <input type="text" name="region" placeholder="Entrez votre région" required>
    <input type="submit" value="S'inscrire">
    <br>
    <br>
    <div class="center-container">
    <a href="connexion.php" class="btn_conn">Aller à la page de connexion</a>
    </div>
</form>

<!-- Message de succès pour l'ajout d'un nouvel utilisateur -->
<?php if (!empty($succesMessage)) : ?>
    <p class="success"><?php echo $succesMessage; ?></p>
<?php endif; ?>
<header>
<h1>Venez vous inscrire sur notre librairie !</h1>

</header>
    <section class="book-display">
        <article class="book">
            <img src="images/Un-coeur-fier.jpg" alt="Couverture du livre 1">
            <h2>Un Coeur fier</h2>
            <p>Auteur : Pearl Buck</p>
            <p>" Je ne veux manquer à aucune tâche. J'arriverai à être à la fois épouse, mère... et moi-même ". Pour Susan, être elle-même, c'est devenir sculpteur. Créer lui est indispensable, mais elle veut aussi vivre. Pour cet être particulièrement doué, la réussite d'une vie pleine et féconde serait facile ; il lui faudra toutefois compter avec les autres, car Susan diffère trop de la mesure commune pour être tolérée.
Pearl Buck s'est inspirée de son propre drame conjugal pour ce roman émouvant retraçant le combat livré par une femme déchirée entre son art et ses obligations d'épouse.</p>
        </article>
    </section>

    <footer>
        <p>&copy; 2023 Librairie en Ligne</p>
    </footer>
</body>
</html>
