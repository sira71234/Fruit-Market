<?php
include("header.php"); 
include 'php/config.php';

$search = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $query = "SELECT * FROM produits WHERE nom LIKE '%$search%'";
} else {
    $query = "SELECT * FROM produits";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Produits</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header>
        <h1>Nos Fruits et Légumes</h1>
        <form action="produits.php" method="GET">
            <input type="text" name="search" placeholder="Rechercher un produit..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Rechercher</button>
        </form>
    </header>

    <section class="produits">
        <h2>Quelques produits populaires</h2>
        <div class="produits-container">
            <?php
            $query = "SELECT * FROM produits LIMIT 20";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                // Conversion du prix en F CFA
                $prixFCA = $row['prix'] * 655.957;

                echo '<div class="produit">
                        <img src="'.$row["photo"].'" alt="'.$row["nom"].'">
                        <h3>'.$row["nom"].'</h3>
                        <p>Prix : '.number_format($prixFCA, 2).' F CFA/kg</p>';
                if ($row["remise"] > 0) {
                    $prixRemise = $row["prix"] * (1 - $row["remise"] / 100);
                    $prixRemiseFCA = $prixRemise * 655.957;
                    echo '<p><s>'.number_format($prixFCA, 2).' F CFA/kg</s> <b>'.number_format($prixRemiseFCA, 2).' F CFA/kg</b></p>';
                }
                echo '<a href="details.php?id='.$row["id"].'">Voir le produit</a>
                    </div>';
            }
            ?>
        </div>
    </section>

</body>
</html>

<?php include("footer.php"); ?>