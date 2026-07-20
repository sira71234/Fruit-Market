<?php

session_start();
include 'php/config.php';

// Définir le taux de conversion Euro -> F CFA
$taux_conversion = 655.957;

if (empty($_SESSION["panier"])) {
    echo "<p class='empty'>Votre panier est vide.</p>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION["commande"] = $_POST;
    header("Location: facture.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de commande</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .commande {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        img {
            width: 80px;
            height: auto;
            border-radius: 5px;
        }
        .btn-valider {
            display: block;
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            font-size: 16px;
        }
        .btn-valider:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<?php include("header.php"); ?>

<header>
    <h1 style="text-align: center;">Confirmation de votre commande</h1>
</header>

<section class="commande">
    <h2>Récapitulatif de votre commande</h2>
    <table>
        <tr>
            <th>Produit</th>
            <th>Image</th>
            <th>Quantité</th>
            <th>Prix Unitaire (F CFA)</th>
            <th>Total (F CFA)</th>
        </tr>

        <?php
        $total = 0;
        $ids = implode(",", array_keys($_SESSION["panier"]));
        $query = "SELECT * FROM produits WHERE id IN ($ids)";
        $result = mysqli_query($conn, $query);

        while ($produit = mysqli_fetch_assoc($result)) {
            $id = $produit["id"];
            $quantite = $_SESSION["panier"][$id];
            $prixFinal = $produit["prix"] * (1 - $produit["remise"] / 100);
            $totalProduit = $prixFinal * $quantite;
            $total += $totalProduit;
        ?>
        <tr>
            <td><?php echo $produit["nom"]; ?></td>
            <td><img src="<?php echo $produit["photo"]; ?>" alt="<?php echo $produit["nom"]; ?>"></td>
            <td><?php echo $quantite; ?> kg</td>
            <td><?php echo number_format($prixFinal * $taux_conversion, 0, ',', ' '); ?> F CFA</td>
            <td><?php echo number_format($totalProduit * $taux_conversion, 0, ',', ' '); ?> F CFA</td>
        </tr>
        <?php } ?>

        <tr>
            <td colspan="4"><b>Total :</b></td>
            <td><b><?php echo number_format($total * $taux_conversion, 0, ',', ' '); ?> F CFA</b></td>
        </tr>
    </table>

    <h2>Informations de livraison</h2>
    <form action="commande.php" method="POST">
        <label>Nom :</label>
        <input type="text" name="nom" required>

        <label>Email :</label>
        <input type="email" name="email" required>

        <label>Adresse :</label>
        <textarea name="adresse" required></textarea>

        <label>Moyen de paiement :</label>
        <select name="paiement">
            <option value="Carte bancaire">Carte bancaire</option>
            <option value="PayPal">PayPal</option>
            <option value="Espèces">Espèces</option>
        </select>

        <button type="submit" class="btn-valider">Valider la commande</button>
    </form>
</section>

<?php include("footer.php"); ?>

</body>
</html>