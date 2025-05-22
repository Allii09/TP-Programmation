<link rel="stylesheet" href="menu.css">
<!-- FontAwesome pour les icônes -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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

<script>
// Script de déconnexion
document.getElementById("logoutBtn").addEventListener("click", function(e) {
    e.preventDefault();

    // Supprimer le token localStorage (si utilisé)
    localStorage.removeItem("client_token");

    // Appeler logout.php pour détruire la session
    fetch("logout.php", { method: "POST" })
    .then(() => {
        // Rediriger vers la page d'accueil
        window.location.href = "index.html";
    })
    .catch(() => {
        // Rediriger même en cas d’erreur
        window.location.href = "index.html";
    });
});
</script>