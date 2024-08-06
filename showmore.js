// La fonction loadMoreItems est une fonction qui permet d'afficher plus de films ou de séries en cliquant sur un bouton
// Elle utilise fetch pour envoyer une requête POST à l'URL correspondante et récupérer la réponse
// Elle utilise ensuite innerHTML pour ajouter les nouveaux films ou séries à la liste existante

let limit = 12; // Initialiser le LIMIT
let offset = 0; // Initialiser l'OFFSET

function loadMoreItems(type) { // Modifier le nom de la fonction et ajouter un paramètre 'type'
  offset += limit; // Augmenter l'OFFSET de la valeur de LIMIT à chaque clic
  const form = document.querySelector('.filters-form'); // Récupérer le formulaire
  const formData = new FormData(form); // Récupérer les données du formulaire

  // Ajouter le limit et offset à formData
  formData.append('limit', limit); // Ajouter la valeur de LIMIT
  formData.append('offset', offset); // Ajouter la valeur de OFFSET

  // Déterminer l'URL en fonction du type
  const url = type === 'series' ? 'getallseries.php' : 'getallfilms.php';

  fetch(url, { // Envoyer une requête POST à l'URL
    method: 'POST',
    body: new URLSearchParams(formData)
  })
  .then(response => response.text()) // Récupérer la réponse
  .then(data => {
    const listContainer = document.querySelector(".listefilms") || document.querySelector(".listeseries"); // Récupérer le conteneur de la liste
    if (listContainer) {
      listContainer.innerHTML += data; // Ajouter les nouveaux films ou séries à la liste existante
    }
  })
  .catch(error => console.error('Error:', error)); // Gérer les erreurs
}

