<?php
session_start();
include 'php/config.php';

// Ajouter un produit au panier
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id = $_POST["id"];
    $quantite = max(1, (int) $_POST["quantite"]);

    if (!isset($_SESSION["panier"])) {
        if (isset($_POST['produit_id']) && is_numeric($_POST['produit_id'])) {
            $_SESSION['panier'][] = intval($_POST['produit_id']);
        } else {
            echo "Erreur : ID de produit invalide.";
        }
        
    }

    if (isset($_SESSION["panier"][$id])) {
        if (isset($_POST['produit_id']) && is_numeric($_POST['produit_id'])) {
            $_SESSION['panier'][] = intval($_POST['produit_id']);
        } else {
            echo "Erreur : ID de produit invalide.";
        }
        
    } else {
        $_SESSION["panier"][$id] = $quantite;
    }

    header("Location: panier.php");
    exit();
}

// Supprimer un produit du panier
if (isset($_GET["action"]) && $_GET["action"] == "remove" && isset($_GET["id"])) {
    $id = $_GET["id"];
    unset($_SESSION["panier"][$id]);
    header("Location: panier.php");
    exit();
}

// Modifier la quantité d'un produit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    foreach ($_POST["quantite"] as $id => $quantite) {
        $_SESSION["panier"][$id] = max(1, (int) $quantite);
    }
    header("Location: panier.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include("header.php"); ?>
<header>
    <h1>Votre Panier</h1>
</header>

<section class="panier">
    <?php if (!empty($_SESSION["panier"])): ?>
        <form action="panier.php" method="POST">
            <table>
                <tr>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>

                <?php
                $total = 0;
                foreach ($_SESSION["panier"] as $id => $quantite) {
                    $query = "SELECT * FROM produits WHERE id = $id";
                    $result = mysqli_query($conn, $query);
                    $produit = mysqli_fetch_assoc($result);

                    $prixRemise = $produit["prix"] * (1 - $produit["remise"] / 100);
                    $prixRemiseFCA = $prixRemise * 655.957;
                    $totalProduit = $prixRemiseFCA * $quantite;
                    $total += $totalProduit;
                ?>
                <tr>
                    <td><?php echo $produit["nom"]; ?></td>
                    <td><?php echo number_format($prixRemiseFCA, 2); ?> F CFA/kg</td>
                    <td>
                        <input type="number" name="quantite[<?php echo $id; ?>]" value="<?php echo $quantite; ?>" min="1">
                    </td>
                    <td><?php echo number_format($totalProduit, 2); ?> F CFA</td>
                    <td>
                        <a href="panier.php?action=remove&id=<?php echo $id; ?>">❌ Supprimer</a>
                    </td>
                </tr>
                <?php } ?>

                <tr>
                    <td colspan="3"><b>Total :</b></td>
                    <td><b><?php echo number_format($total, 2); ?> F CFA</b></td>
                    <td></td>
                </tr>
            </table>

            <button type="submit" name="update">Mettre à jour</button>
            <a href="commande.php" class="btn">Passer la commande</a>
        </form>
    <?php else: ?>
        <p>Votre panier est vide.</p>
    <?php endif; ?>
</section>
<?php include("footer.php"); ?>
</body>
</html>