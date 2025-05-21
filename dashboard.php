<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Connexion à la base de données
$host = "localhost";
$dbname = "stock_produit";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Préparer la requête pour récupérer uniquement les commandes du client connecté
    $stmt = $pdo->prepare("SELECT id_commande, statut, total FROM commande WHERE user_id = ?");
    $stmt->execute([$user_id]);

} catch (PDOException $e) {
    $error_message = "Erreur de connexion : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="style.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <nav>
                <ul class="nav-list">
                    <li><a href="dashboard.php" class="nav-item"><i class="fas fa-home"></i> Accueil</a></li>
                    <li><a href="commande.php" class="nav-item"><i class="fas fa-shopping-cart"></i> Passer une commande</a></li>
                    <li><a href="produits.php" class="nav-item"><i class="fas fa-box-open"></i> Nos produits</a></li>
                    <li><a href="#" id="logoutBtn" class="nav-item"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></li>
                </ul>
            </nav>
        </aside>

        <main class="content">
            <h1>Bienvenue sur votre tableau de bord</h1>

            <h2>Vos commandes effectuées</h2>
            <table class="commandes-table">
                <thead>
                    <tr>
                        <th>ID Commande</th>
                        <th>Statut</th>
                        <th>Montant</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($error_message)) {
                        echo "<tr><td colspan='3'>" . htmlspecialchars($error_message) . "</td></tr>";
                    } else {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id_commande']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['statut']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['total']) . " MAD</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </main>
    </div>
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
