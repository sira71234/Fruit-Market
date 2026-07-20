<?php
$host = "localhost";
$user = "root";
$pass = ""; 
$db = "site_vente";

$conn = mysqli_connect($host, $user, $pass, $db);

// Vérifier la connexion
if (!$conn) {
    die("Connexion échouée : " . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8")
?>