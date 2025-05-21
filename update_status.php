<?php
header('Content-Type: application/json');

$host = "localhost";
$dbname = "stock_produit";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['id_commande'], $data['statut'])) {
        echo json_encode(['success' => false, 'message' => 'Données manquantes.']);
        exit;
    }

    $id_commande = intval($data['id_commande']);
    $statut = htmlspecialchars($data['statut']);

    $stmt = $pdo->prepare("UPDATE commande SET statut = :statut WHERE id_commande = :id");
    $stmt->execute(['statut' => $statut, 'id' => $id_commande]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
