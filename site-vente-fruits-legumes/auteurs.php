<?php
$auteurs = [
    ["nom" => "OKE Siracide", "role" => "Chef de projet <br> Supervise le projet et gère la base de données MySQL (structuration, requêtes, tests).", "image" => "images/OKE siracide.jpg"],
    ["nom" => "ANATO Sèdjro David", "role" => "Développe les fonctionnalités PHP (gestion des produits, panier, commandes) et sécurise le site.", "image" => "images/ANATO Sèdjro David.jpg"],
    ["nom" => "KEREKOU Maëlle", "role" => "Conçoit l’interface utilisateur avec HTML/CSS et JavaScript pour un design responsive.", "image" => "images/KEREKOU Maëlle.jpg"],
    ["nom" => "HOUNKPEVI Véronique", "role" => "Implémente le panier, le moteur de recherche et génère les factures en PDF.", "image" => "images/HOUNKPEVI Véronique.jpg"],
    ["nom" => "HOUNNOUVI Esdras", "role" => "Rédige la documentation, effectue les tests et crée la page des auteurs.", "image" => "images/HOUNNOUVI Esdras.jpg"],
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auteurs</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include("header.php"); ?>
    
    <section class="auteurs">
        <h1>Les auteurs du projet</h1>

        <div class="auteurs-container">
            <?php foreach ($auteurs as $auteur) : ?>
                <div class="auteur">
                    <img src="<?= $auteur['image']; ?>" alt="<?= $auteur['nom']; ?>">
                    <h3><?= $auteur['nom']; ?></h3>
                    <p><strong><?= $auteur['role']; ?></strong></p>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php include("footer.php"); ?>
</body>
</html>

