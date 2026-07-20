<?php
session_start();
require('php/fpdf/fpdf.php');
header('Content-Type: text/html;charset=UTF-8');

if (!isset($_SESSION["commande"]) || empty($_SESSION["panier"])) {
    echo "Aucune commande trouvée.";
    exit();
}

$nom = $_SESSION["commande"]["nom"];
$adresse = $_SESSION["commande"]["adresse"];
$paiement = $_SESSION["commande"]["paiement"];
$total = 0;

// Conversion en F CFA
$taux_conversion = 655.957;

class PDF extends FPDF {
    function Header() {
        // Logo
        $this->Image('images/logo.jpg', 10, 10, 30);
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, "Facture - Fruits Market", 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, "Merci pour votre confiance - Fruits Market", 0, 0, 'C');
    }
}

// Création du document PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Infos client
$pdf->Cell(0, 10, "Client : " . utf8_decode($nom), 0, 1);
$pdf->Cell(0, 10, "Adresse : " . utf8_decode($adresse), 0, 1);
$pdf->Cell(0, 10, "Mode de paiement : " . utf8_decode($paiement), 0, 1);
$pdf->Ln(10);

// Tableau des produits
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetFillColor(200, 200, 200);
$pdf->Cell(80, 10, "Produit", 1, 0, 'C', true);
$pdf->Cell(30, 10, "Quantite", 1, 0, 'C', true);
$pdf->Cell(40, 10, "Prix (F CFA)", 1, 0, 'C', true);
$pdf->Cell(40, 10, "Total (F CFA)", 1, 1, 'C', true);
$pdf->SetFont('Arial', '', 12);

include 'php/config.php';

foreach ($_SESSION["panier"] as $id => $quantite) {
    $query = "SELECT * FROM produits WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $produit = mysqli_fetch_assoc($result);

    $prixFinal = ($produit["prix"] * (1 - $produit["remise"] / 100)) * $taux_conversion;
    $totalProduit = $prixFinal * $quantite;
    $total += $totalProduit;

    $pdf->Cell(80, 10, utf8_decode($produit["nom"]), 1);
    $pdf->Cell(30, 10, $quantite . " kg", 1);
    $pdf->Cell(40, 10, number_format($prixFinal, 2) . " F CFA", 1);
    $pdf->Cell(40, 10, number_format($totalProduit, 2) . " F CFA", 1);
    $pdf->Ln();
}

// Total général
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(110, 10, "", 0);
$pdf->Cell(40, 10, "Total :", 1);
$pdf->Cell(40, 10, number_format($total, 2) . " F CFA", 1);
$pdf->Ln(20);

// Message de remerciement
$pdf->SetFont('Arial', 'I', 12);
$pdf->Cell(0, 10, "Merci pour votre commande !", 0, 1, 'C');

// Génération et téléchargement du fichier PDF
$pdf->Output("D", "facture.pdf");

// Vider le panier après génération de la facture
unset($_SESSION["panier"]);
unset($_SESSION["commande"]);

exit();
?>