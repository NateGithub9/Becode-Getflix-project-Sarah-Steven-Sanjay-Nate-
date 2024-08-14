let offset = 5;
let limit = 5; // Nombre de commentaires à charger à chaque fois

function loadMoreComments() {
    console.log("Fonction loadMoreComments initialisée"); // Vérifiez que la fonction est chargée

    document.addEventListener('DOMContentLoaded', function() {
        console.log("DOMContentLoaded exécuté"); // Confirmez que le DOM est entièrement chargé

        const button = document.getElementById('loadMoreComments');
        console.log("Bouton récupéré:", button); // Vérifiez que l'élément bouton est correctement récupéré

        if (button) {
            button.addEventListener('click', function() {
                console.log('Le bouton a été cliqué'); // Confirmez que le clic est détecté
                console.log(`URL : loadmorecomments.php?limit=${limit}&offset=${offset}`); // Affichez l'URL appelée

                fetch(`loadmorecomments.php?limit=${limit}&offset=${offset}`)
                    .then(response => response.text())  // Assurez-vous que votre serveur renvoie du HTML
                    .then(html => {
                        console.log("HTML reçu:", html); // Affichez le HTML reçu pour débogage
                        const commentsTableBody = document.getElementById("commentsTableBody");
                        commentsTableBody.innerHTML += html;  // Ajoutez le HTML reçu à la table existante
                        limit += 5;
                        offset += 5;
                        console.log("Nouvel offset:", offset); // Affichez le nouvel offset pour débogage
                        console.log("Nouvelle limite:", limit); // Affichez la nouvelle limite pour débogage
                    })
                    .catch(error => console.error('Erreur lors de la requête:', error));
            });
        } else {
            console.error("Erreur: Le bouton 'loadMoreComments' n'a pas été trouvé dans le DOM.");
        }
    });
}

loadMoreComments();  // Assurez-vous que cette ligne est présente pour appeler la fonction