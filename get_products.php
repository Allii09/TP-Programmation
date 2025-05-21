<?php
header('Content-Type: application/json');

$host = "localhost";
$dbname = "stock_produit";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier si on demande un produit spécifique (pour l'édition)
    if (isset($_GET['id'])) {
        $stmt = $pdo->prepare("SELECT id, nom, description, quantite, prix, image_path FROM produits WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($product);
    } else {
        // Récupération de tous les produits
        $stmt = $pdo->query("SELECT id, nom, description, quantite, prix, image_path FROM produits ORDER BY id DESC");
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($products);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>