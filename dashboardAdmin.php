<?php
// Connexion base de données
$host = "localhost";
$dbname = "stock_produit";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer toutes les commandes
    $stmt = $pdo->query("SELECT id_commande, user_id, statut, total FROM commande ORDER BY id_commande DESC");
    $commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $error_message = "Erreur de connexion : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard Admin - Commandes</title>
    <link rel="stylesheet" href="style.css" />
    <script>
    function updateStatus(id_commande, newStatus) {
        if (!confirm("Êtes-vous sûr de vouloir changer le statut de cette commande ?")) return;

        fetch('update_status.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_commande: id_commande, statut: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Statut mis à jour avec succès !");
                location.reload();
            } else {
                alert("Erreur : " + data.message);
            }
        })
        .catch(() => alert("Erreur de communication avec le serveur."));
    }
    </script>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <nav>
                <ul class="nav-list">
                    <li><a href="dashboardAdmin.php" class="nav-item"><i class="fas fa-home"></i> Accueil</a></li>
                    <li><a href="dashboardAdmin.php" class="nav-item"><i class="fas fa-shopping-cart"></i> Voir les commande</a></li>
                    <li><a href="add_product.html" class="nav-item"><i class="fas fa-box-open"></i> Ajuter un produit</a></li>
                    <li><a href="#" id="logoutBtn" class="nav-item"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
                </ul>
            </nav>
        </aside>

        <main class="content">
            <h1>Tableau de bord Admin - Gestion des commandes</h1>

            <?php if (isset($error_message)) : ?>
                <p style="color:red;"><?= htmlspecialchars($error_message) ?></p>
            <?php endif; ?>

            <table class="commandes-table">
                <thead>
                    <tr>
                        <th>ID Commande</th>
                        <th>ID Client</th>
                        <th>Statut</th>
                        <th>Montant</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($commandes as $commande): ?>
                        <tr>
                            <td><?= htmlspecialchars($commande['id_commande']) ?></td>
                            <td><?= htmlspecialchars($commande['user_id']) ?></td>
                            <td><?= htmlspecialchars($commande['statut']) ?></td>
                            <td><?= htmlspecialchars($commande['total']) ?> MAD</td>
                            <td>
                                <button onclick="updateStatus(<?= $commande['id_commande'] ?>, 'En cours de livraison')">Confirmer</button>
                                <button onclick="updateStatus(<?= $commande['id_commande'] ?>, 'Commande annulée')">Annuler</button>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
    <!-- Ajoute le script FontAwesome pour les icônes si besoin -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
     <script>
    document.getElementById("logoutBtn").addEventListener("click", function(e) {
        e.preventDefault();

        // Supprimer le token localStorage
        localStorage.removeItem("client_token");

        // Appeler logout.php pour détruire la session
        fetch("logout.php", { method: "POST" })
        .then(() => {
            // Rediriger vers la page d'accueil index.html
            window.location.href = "index.html";
        })
        .catch(() => {
            // En cas d’erreur, rediriger quand même
            window.location.href = "index.html";
        });
    });
    </script>
</body>
</html>
