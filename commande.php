<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passer une Commande</title>
    <link rel="stylesheet" href="commande.css">


</head>
<body>

    <div class="container">
        <h1>Passer une Commande</h1>
        
        <div class="form-container">
            <h2>Nouvelle Commande</h2>
            <form id="order-form">
                <div class="form-group">
                    <label>Produits:</label>
                    <div id="products-selection">
                        <!-- Les produits seront ajoutés ici dynamiquement -->
                    </div>
                    <button type="button" id="add-product-btn" class="btn">+ Ajouter un produit</button>
                </div>
                
                <div class="form-group">
                    <label for="delivery-address">Adresse de livraison:</label>
                    <textarea id="delivery-address" rows="3" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="order-notes">Notes (optionnel):</label>
                    <textarea id="order-notes" rows="2"></textarea>
                </div>
                
                <div class="form-group">
                    <label>Total: <span id="order-total">0.00</span> MAD</label>
                </div>
                
                <button type="submit" class="btn btn-success">Valider la commande</button>
            </form>
        </div>
    </div>
    <script>
document.addEventListener('DOMContentLoaded', () => {
    const productsSelection = document.getElementById('products-selection');
    const addProductBtn = document.getElementById('add-product-btn');
    const orderTotal = document.getElementById('order-total');
    let productsData = [];

    // Charger les produits depuis le serveur
    fetch('get_products.php')
        .then(response => response.json())
        .then(data => {
            productsData = data;
            addProductRow(); // Ajouter une ligne par défaut
        });

    // Fonction pour ajouter une ligne produit
    function addProductRow() {
        const row = document.createElement('div');
        row.className = 'product-row';

        const select = document.createElement('select');
        select.innerHTML = `<option value="">-- Choisir un produit --</option>`;
        productsData.forEach(p => {
            select.innerHTML += `<option value="${p.id}" data-price="${p.prix}">${p.nom} (${p.prix} MAD)</option>`;
        });

        const quantity = document.createElement('input');
        quantity.type = 'number';
        quantity.min = 1;
        quantity.value = 1;

        select.addEventListener('change', updateTotal);
        quantity.addEventListener('input', updateTotal);

        row.appendChild(select);
        row.appendChild(quantity);
        productsSelection.appendChild(row);

        updateTotal();
    }

    addProductBtn.addEventListener('click', addProductRow);

    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.product-row').forEach(row => {
            const select = row.querySelector('select');
            const quantity = row.querySelector('input');
            const price = parseFloat(select.selectedOptions[0]?.dataset.price || 0);
            const qty = parseInt(quantity.value || 0);
            total += price * qty;
        });
        orderTotal.textContent = total.toFixed(2);
    }

    // Gestion de la soumission du formulaire
    document.getElementById('order-form').addEventListener('submit', function (e) {
        e.preventDefault();

        const rows = document.querySelectorAll('.product-row');
        const produits = [];

        rows.forEach(row => {
            const select = row.querySelector('select');
            const quantity = row.querySelector('input');
            if (select.value) {
                produits.push({
                    id_produit: parseInt(select.value),
                    quantite: parseInt(quantity.value)
                });
            }
        });

        const data = {
            produits: produits,
            adresse: document.getElementById('delivery-address').value,
            notes: document.getElementById('order-notes').value,
            total: parseFloat(orderTotal.textContent)
        };

        fetch('save_order.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        }).then(res => res.json())
          .then(response => {
              alert(response.message || 'Commande enregistrée avec succès');
              location.reload();
          }).catch(err => {
              alert('Erreur lors de la commande');
          });
    });
});
</script>


   
</body>
</html>