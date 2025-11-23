<?php
$serveur = "localhost";
$utilisateur = "root";
$mot_passe = "";
$base = "users";
$conn=mysqli_connect($serveur,$utilisateur,$mot_passe,$base);

if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}

?>