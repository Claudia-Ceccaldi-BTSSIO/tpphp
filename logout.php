<?php
session_start(); 

// Efface toutes les variables de session
$_SESSION = array();

// Détruis la session
session_destroy();

// Redirige vers la page index
header("Location: index.php");
exit;
?>
