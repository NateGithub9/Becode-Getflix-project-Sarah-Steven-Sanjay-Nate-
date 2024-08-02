
// C'est le code pour faire une recherche pour les films

// On récupère les éléments de l'interface utilisateur qui sont nécessaires pour la recherche
// - searchInput : l'input de recherche
// - searchResults : l'endroit où seront affichés les résultats
const searchInput = document.getElementById('searchInput');
const searchResults = document.getElementById('searchResults');

// On ajoute un écouteur d'événement sur l'input de recherche
// Quand l'utilisateur modifie ce qu'il écrit dans l'input, cette fonction est appelée
searchInput.addEventListener('input', function() {

    // On récupère la valeur de l'input de recherche en minuscules
    const searchTerm = searchInput.value.toLowerCase();

    // On crée une requête HTTP POST vers le fichier PHP de recherche avec la valeur de l'input en tant que paramètre
    // Le paramètre est nommé "query" et encodé en URL
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'searchfilmsdb.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Lorsque la réponse de la requête est prête, cette fonction est appelée
    xhr.onreadystatechange = function() {

        // Si la réponse est prête et que le code de la réponse est 200 (OK)
        if (xhr.readyState === 4 && xhr.status === 200) {

            // On récupère les résultats de la requête en JSON et on les passe à la fonction displayFilmsResults()
            const results = JSON.parse(xhr.responseText);
            displayFilmsResults(results);
        }
    };

    // On envoie la requête avec le paramètre "query"
    xhr.send('query=' + encodeURIComponent(searchTerm));
});

// Cette fonction prend en argument les résultats de la recherche et les affiche dans l'interface utilisateur
function displayFilmsResults(results) {

    // On vide l'élément searchResults afin de ne garder que les résultats de la recherche actuelle
    searchResults.innerHTML = '';

    // On crée un élément table pour afficher les résultats
    const table = document.createElement('table');

    // Si des résultats sont trouvés
    if (results.length > 0) {
        results.forEach(function(result) {
            const tr = document.createElement('tr'); // On crée une ligne pour chaque résultat
            const link = document.createElement('a'); // On crée un lien pour chaque titre de résultat
            link.textContent = result.titre; // On met le titre du résultat dans le lien
            link.href = 'filmsdetails.php?id=' + result.id; // On met l'URL de la page de détail du résultat dans le lien
            tr.appendChild(link); // On ajoute le lien à la ligne
            table.appendChild(tr); // On ajoute la ligne à la table
        });
    } else { // Si aucun résultat n'est trouvé, on affiche un message
        const p = document.createElement('p');
        p.textContent = 'Aucun résultat trouvé.';
        searchResults.appendChild(p);
    }

    // On ajoute la table à l'élément searchResults afin d'afficher les résultats
    searchResults.appendChild(table);
}




