<?php
include 'php/config.php';
$stmt = $conn->prepare("SELECT * FROM produits LIMIT ?");
$limit = 4;
$stmt->bind_param("i", $limit);
$stmt->execute();
$result = $stmt->get_result();


// Vérification si la requête a bien retourné des résultats
if ($result && mysqli_num_rows($result) > 0) {
    $taux_conversion = 655.957;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fruits Market - Accueil</title>
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include("header.php"); ?>

<header>
    <h1>Bienvenue sur Fruits Market</h1>
</header>

<section class="infos">
    <h2>Pourquoi choisir nos produits ?</h2>
    <ul>
        <li>🍎 Produits frais et de qualité</li>
        <li>🥦 Prix abordables et remises exclusives</li>
        <li>🚚 Livraison rapide et fiable</li>
        <li>🌱 Aliments sains pour une meilleure alimentation</li>
    </ul>
</section>

<section class="produits">
    <h2>Nos Produits</h2>
    <div class="produits-container">
        <?php while ($produit = mysqli_fetch_assoc($result)): 
            $prixFCA = $produit['prix'] * $taux_conversion;
            $prixRemiseFCA = $prixFCA; // Valeur par défaut

            if (!empty($produit["remise"]) && $produit["remise"] > 0) {
                $prixRemiseFCA = ($produit["prix"] * (1 - $produit["remise"] / 100)) * $taux_conversion;
            }
        ?>
            <div class="produit">
                <img src="<?php echo htmlspecialchars($produit['photo']); ?>" alt="<?php echo htmlspecialchars($produit['nom']); ?>">
                <h3><?php echo htmlspecialchars($produit['nom']); ?></h3>
                <p><b>Description :</b> <?php echo htmlspecialchars($produit['detail']); ?></p>
                <p><b>Catégorie :</b> <?php echo htmlspecialchars($produit['categorie']); ?></p>
                <p><b>Prix :</b> 
                    <?php if (!empty($produit["remise"]) && $produit["remise"] > 0): ?>
                        <s><?php echo number_format($prixFCA, 2); ?> F CFA/kg</s>
                        <b><?php echo number_format($prixRemiseFCA, 2); ?> F CFA/kg</b>
                    <?php else: ?>
                        <b><?php echo number_format($prixFCA, 2); ?> F CFA/kg</b>
                    <?php endif; ?>
                </p>
                
            </div>
        <?php endwhile; ?>
    </div>
</section>

<?php include("footer.php"); ?>

</body>
</html>
<?php
} else {
    echo "<p>Aucun produit disponible pour le moment.</p>";
}
?>