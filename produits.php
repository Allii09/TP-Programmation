<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Produits</title>
<link rel="stylesheet" href="product.css"></head>
<body>
    <?php include('menu.php'); ?>
    <header>
        <h1>Nos Produits</h1>
    </header>

    <main class="products-container">
        <!-- Les produits seront chargés dynamiquement ici -->
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('get_products.php')
                .then(response => response.json())
                .then(products => {
                    const container = document.querySelector('.products-container');
                    
                    products.forEach(product => {
                        const productCard = document.createElement('div');
                        productCard.className = 'product-card';
                        
                        productCard.innerHTML = `
                            <div class="product-image">
                                ${product.image_path ? 
                                    `<img src="${product.image_path}" alt="${product.nom}">` : 
                                    `<div class="no-image">Pas d'image</div>`}
                            </div>
                            <div class="product-info">
                                <h3 class="product-name">${product.nom}</h3>
                                <p class="product-description">${product.description || 'Aucune description disponible'}</p>
                                <div class="product-footer">
                                    <span class="product-price">${parseFloat(product.prix).toFixed(2)} DH</span>
                                    <a href="commande.php" class="product-stock">Commander maintenant</a>
                                </div>
                            </div>
                        `;
                        
                        container.appendChild(productCard);
                    });
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    document.querySelector('.products-container').innerHTML = 
                        '<p class="error">Erreur lors du chargement des produits</p>';
                });
        });
    </script>
</body>
</html>