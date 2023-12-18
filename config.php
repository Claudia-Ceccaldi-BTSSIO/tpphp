<?php
// Paramètres de connexion à la base de données
$servername = 'localhost';
$username = 'root';
$dbpassword = '';
$database = 'tp2phppoo';

// Connexion à la base de données en utilisant mysqli
$connexion = new mysqli($servername, $username, $dbpassword, $database);

// Vérification de la connexion 
if ($connexion->connect_error) {
    die('Erreur de connexion à la base de données : ' . $connexion->connect_error);
}

// Configuration des caractères d'encodage pour éviter les problèmes d'encodage
$connexion->set_charset('utf8mb4');

// Activation du mode strict pour les requêtes
$connexion->query("SET sql_mode = 'STRICT_ALL_TABLES';");
?>
