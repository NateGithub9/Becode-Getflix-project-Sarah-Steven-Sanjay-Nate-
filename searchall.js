// Recherche pour les films et séries

// On récupère les éléments de l'interface utilisateur qui sont nécessaires pour la recherche
const searchInputHomePage = document.getElementById('searchInputHomePage');
const searchResultsHomePage = document.getElementById('searchResultsHomePage');

// On ajoute un écouteur d'événement sur l'input de recherche
searchInputHomePage.addEventListener('input', function() {

    // On récupère la valeur de l'input de recherche en minuscules
    const searchTermHomePage = searchInputHomePage.value.toLowerCase();

    // On crée une requête HTTP POST vers le fichier PHP de recherche
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'searchalldb.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // On ajoute un écouteur d'événement pour vérifier si la requête est terminée
    xhr.onreadystatechange = function() {

        // On vérifie si la requête est terminée et si son statut est 200 (OK)
        if (xhr.readyState === 4 && xhr.status === 200) {

            // On récupère les résultats de la requête en tant que tableau JSON
            const results = JSON.parse(xhr.responseText);

            // On appelle la fonction displayAllResults pour afficher les résultats
            displayAllResults(results);
        }
    };

    // On envoie la requête avec la valeur de l'input de recherche
    xhr.send('query=' + encodeURIComponent(searchTermHomePage));
});

// Cette fonction prend en paramètre les résultats de la recherche et les affiche dans l'interface utilisateur
function displayAllResults(results) {
    searchResultsHomePage.innerHTML = '';
    const table = document.createElement('table');

    // Si des résultats sont trouvés
    if (results.length > 0) {
        results.forEach(function(result) {
            const tr = document.createElement('tr');
            const link = document.createElement('a');
            
            // On vérifie le type de l'élément pour déterminer l'URL de la page de détail
            // Vérifie la table d'origine pour déterminer le type de l'élément
            const baseUrl = result.type === 'Film' ? 'filmsdetails.php' : 'seriesdetails.php';
            
            // On ajoute le titre de l'élément dans la balise <a>
            link.textContent = result.titre;
            
            // On ajoute l'URL de la page de détail avec l'ID de l'élément
            link.href = baseUrl + '?id=' + result.id;
            tr.appendChild(link);
            table.appendChild(tr);
        });
    } else {
        const p = document.createElement('p');
        p.textContent = 'Aucun résultat trouvé.';
        searchResultsHomePage.appendChild(p);
    }
    searchResultsHomePage.appendChild(table);
}
