<?php
include 'php/config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Produit introuvable.";
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = "SELECT * FROM produits WHERE id = $id";
$result = mysqli_query($conn, $query);
$produit = mysqli_fetch_assoc($result);

if (!$produit) {
    echo "Produit introuvable.";
    exit;
}

// Conversion des prix en F CFA
$taux_conversion = 655.957;
$prixFCA = $produit['prix'] * $taux_conversion;
$prixRemiseFCA = $prixFCA;

if ($produit["remise"] > 0) {
    $prixRemiseFCA = ($produit["prix"] * (1 - $produit["remise"] / 100)) * $taux_conversion;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($produit['nom']); ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include("header.php"); ?>

<header>
    <h1><?php echo htmlspecialchars($produit['nom']); ?></h1>
</header>

<section class="produit-detail">
    <img src="<?php echo htmlspecialchars($produit['photo']); ?>" alt="<?php echo htmlspecialchars($produit['nom']); ?>" class="produit-image">
    <p><b>Description :</b> <?php echo htmlspecialchars($produit['detail']); ?></p>
    <p><b>Catégorie :</b> <?php echo htmlspecialchars($produit['categorie']); ?></p>

    <p><b>Prix :</b>
        <?php if ($produit["remise"] > 0): ?>
            <s><?php echo number_format($prixFCA, 2); ?> F CFA/kg</s>
            <b><?php echo number_format($prixRemiseFCA, 2); ?> F CFA/kg</b>
        <?php else: ?>
            <b><?php echo number_format($prixFCA, 2); ?> F CFA/kg</b>
        <?php endif; ?>
    </p>

    <form action="panier.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $produit['id']; ?>">
        <label>Quantité :</label>
        <input type="number" name="quantite" value="1" min="1">
        <button type="submit">Ajouter au panier</button>
    </form>
</section>

<?php include("footer.php"); ?>
</body>
</html>