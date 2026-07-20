
// Gestion du panier interactif let panier = JSON.parse(localStorage.getItem("panier")) || [];

document.querySelectorAll(".ajouter-panier").forEach(button => { button.addEventListener("click", function() { let produit = this.dataset.produit; let prix = parseFloat(this.dataset.prix); let item = panier.find(p => p.produit === produit);

    if (item) {
            item.quantite++;
        } else {
            panier.push({ produit, prix, quantite: 1 });
        }
        localStorage.setItem("panier", JSON.stringify(panier));
        afficherPanier();
    });
    
    });
    
    function afficherPanier() { let panierDiv = document.getElementById("panier"); panierDiv.innerHTML = ""; panier.forEach(item => { panierDiv.innerHTML += <p>${item.produit} x ${item.quantite} - ${item.prix * item.quantite} €</p>; }); }
    
    document.getElementById("vider-panier").addEventListener("click", function() { localStorage.removeItem("panier"); panier = []; afficherPanier(); });
    
    document.addEventListener("DOMContentLoaded", afficherPanier);
    
    // Effets dynamiques sur les boutons document.querySelectorAll("button").forEach(btn => { btn.addEventListener("mouseenter", () => btn.classList.add("hover")); btn.addEventListener("mouseleave", () => btn.classList.remove("hover")); });
    
    // Validation des formulaires document.querySelectorAll("form").forEach(form => { form.addEventListener("submit", function(event) { let valide = true; this.querySelectorAll("input[required]").forEach(input => { if (!input.value.trim()) { valide = false; input.classList.add("error"); } else { input.classList.remove("error"); } }); if (!valide) { event.preventDefault(); alert("Veuillez remplir tous les champs obligatoires."); } }); });
    
    