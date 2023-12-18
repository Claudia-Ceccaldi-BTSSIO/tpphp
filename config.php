<?php
// Paramètres de connexion à la base de données
$servername = 'localhost';
$username = 'root';
$dbpassword = '';
$database = 'tp2phppoo';

try {
    // Connexion à la base de données en utilisant PDO
    $maconnexion = new PDO("mysql:host=$servername;dbname=$database", $username, $dbpassword);
    // Configuration du mode d'erreur PDO à Exception
    $maconnexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Configuration des caractères d'encodage
    $maconnexion->exec("SET NAMES 'utf8mb4'");

    // Activation du mode strict pour les requêtes
    $maconnexion->exec("SET sql_mode = 'STRICT_ALL_TABLES'");

} catch(PDOException $e) {
    echo "Connection échouée: " . $e->getMessage();
}
?>
