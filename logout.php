<?php
session_start(); // Démarrer la session

// Effacer toutes les variables de session
$_SESSION = array();

// Détruire la session
session_destroy();

// Rediriger vers la page index
header("Location: index.php");
exit;
?>
