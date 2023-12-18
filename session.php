<?php
session_start();

if (!isset($_SESSION['utilisateur_id'])) {
    header("location: accueil.php");
    exit;
}
?>
