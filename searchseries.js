// Cette partie de code permet de faire une recherche dans les séries.

// On récupère les éléments de l'interface utilisateur qui sont nécessaires pour la recherche :
// - searchInputSeries : l'input de recherche
// - searchResultsSeries : l'emplacement où seront affichés les résultats

// On ajoute un écouteur d'événement sur l'input de recherche.
// Lorsque l'utilisateur modifie ce qu'il écrit dans l'input, cette fonction est appelée.
searchInputSeries.addEventListener('input', function() {

    // On récupère la valeur de l'input de recherche en minuscules
    const searchTerm = searchInputSeries.value.toLowerCase();

    // On crée une requête HTTP POST vers le fichier PHP de recherche avec la valeur de l'input en tant que paramètre.
    // Le paramètre est nommé "query" et encodé en URL.
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'searchseriesdb.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {

        // Lorsque la requête est terminée, on vérifie que l'état de la requête est "4" (terminé)
        // et que le code de statut de la réponse est "200" (OK).
        if (xhr.readyState === 4 && xhr.status === 200) {

            // On parse les résultats de la requête en JSON.
            const results = JSON.parse(xhr.responseText);

            // On appelle la fonction displaySeriesResults avec les résultats en argument.
            displaySeriesResults(results);
        }
    };
    xhr.send('query=' + encodeURIComponent(searchTerm));
});

// Cette fonction prend en argument les résultats de la recherche
// et les affiche dans l'interface utilisateur.
function displaySeriesResults(results) {

    // On vide l'élément searchResultsSeries afin de ne garder que les résultats de la recherche actuelle.
    searchResultsSeries.innerHTML = '';

    // On crée un élément table pour afficher les résultats.
    const table = document.createElement('table');

    // Si des résultats sont trouvés, on les affiche dans la table.
    if (results.length > 0) {
        results.forEach(function(result) {
            const tr = document.createElement('tr'); // On crée une ligne pour chaque résultat.
            const link = document.createElement('a'); // On crée un lien pour chaque titre de résultat.
            link.textContent = result.titre; // On met le titre du résultat dans le lien.
            link.href = 'seriesdetails.php?id=' + result.id; // On met l'URL de la page de détail du résultat dans le lien.
            tr.appendChild(link); // On ajoute le lien à la ligne.
            table.appendChild(tr); // On ajoute la ligne à la table.
        });
    } else { // Si aucun résultat n'est trouvé, on affiche un message.
        const p = document.createElement('p');
        p.textContent = 'Aucun résultat trouvé.';
        searchResultsSeries.appendChild(p);
    }

    // On ajoute la table à l'élément searchResultsSeries afin d'afficher les résultats.
    searchResultsSeries.appendChild(table);
}


