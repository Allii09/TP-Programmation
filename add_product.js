document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("product-form");
    const message = document.getElementById("message");
    const tableBody = document.getElementById("products-list");
    const imagePreview = document.getElementById("image-preview");

    // Prévisualisation de l'image
    document.getElementById("product-image").addEventListener("change", function(e) {
        imagePreview.innerHTML = '';
        
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const img = document.createElement("img");
                img.src = e.target.result;
                img.style.maxWidth = "100px";
                img.style.maxHeight = "100px";
                imagePreview.appendChild(img);
            }
            
            reader.readAsDataURL(this.files[0]);
        }
    });

    function loadProducts() {
        fetch("get_products.php")
            .then(res => res.json())
            .then(data => {
                tableBody.innerHTML = "";

                data.forEach(product => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>
                            ${product.image_path ? 
                                `<img src="${product.image_path}" alt="${product.nom}" style="max-width: 80px; max-height: 80px;">` : 
                                'Aucune image'}
                        </td>
                        <td>${product.nom}</td>
                        <td>${product.description}</td>
                        <td>${product.quantite}</td>
                        <td>${parseFloat(product.prix).toFixed(2)} DH</td>
                        <td>
                            <button class="edit-btn" data-id="${product.id}">Modifier</button>
                            <button class="delete-btn" data-id="${product.id}">Supprimer</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });

                // Gérer la suppression
                document.querySelectorAll(".delete-btn").forEach(button => {
                    button.addEventListener("click", () => {
                        const id = button.dataset.id;
                        if (confirm("Voulez-vous vraiment supprimer ce produit ?")) {
                            fetch(`delete_product.php?id=${id}`, { method: "GET" })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        loadProducts();
                                    } else {
                                        alert("Erreur : " + data.message);
                                    }
                                });
                        }
                    });
                });

                // Gérer la modification
                document.querySelectorAll(".edit-btn").forEach(button => {
                    button.addEventListener("click", () => {
                        const id = button.dataset.id;

                        fetch(`get_products.php?id=${id}`)
                            .then(res => res.json())
                            .then(product => {
                                document.getElementById("product-id").value = product.id;
                                document.getElementById("product-name").value = product.nom;
                                document.getElementById("product-description").value = product.description;
                                document.getElementById("product-quantity").value = product.quantite;
                                document.getElementById("product-price").value = product.prix;
                                
                                // Afficher l'image existante si elle existe
                                imagePreview.innerHTML = '';
                                if (product.image_path) {
                                    const img = document.createElement("img");
                                    img.src = product.image_path;
                                    img.style.maxWidth = "100px";
                                    img.style.maxHeight = "100px";
                                    imagePreview.appendChild(img);
                                }
                            });
                    });
                });
            })
            .catch(err => {
                console.error("Erreur chargement produits :", err);
            });
    }

    form.addEventListener("submit", function (e) {
        e.preventDefault();
        const formData = new FormData(form);

        fetch("save_product.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                message.textContent = data.message || "Produit ajouté avec succès.";
                message.style.color = "green";
                form.reset();
                imagePreview.innerHTML = '';
                loadProducts();
            } else {
                message.textContent = "Erreur : " + (data.message || "Erreur inconnue");
                message.style.color = "red";
            }
        })
        .catch(() => {
            message.textContent = "Erreur réseau.";
            message.style.color = "red";
        });
    });

    loadProducts();
});