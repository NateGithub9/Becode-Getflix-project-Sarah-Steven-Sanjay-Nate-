// Fonction pour échapper les caractères HTML spéciaux
function escapeHtml(unsafe) {
    return unsafe
         .replace(/&/g, "&amp;")
         .replace(/</g, "&lt;")
         .replace(/>/g, "&gt;")
         .replace(/"/g, "&quot;")
}

// Fonction de debounce pour limiter le nombre de requêtes
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// On récupère les éléments de l'interface utilisateur
const searchInputSeries = document.getElementById('searchInputSeries');
const searchResultsSeries = document.getElementById('searchResultsSeries');

// Fonction de recherche avec debounce
const debouncedSearch = debounce(function() {
    const searchTerm = searchInputSeries.value.toLowerCase();

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'searchseriesdb.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    const results = JSON.parse(xhr.responseText);
                    displaySeriesResults(results);
                } catch (e) {
                    console.error('Erreur lors du parsing JSON:', e);
                    displaySeriesResults([]);
                }
            } else {
                console.error('Erreur de requête:', xhr.status);
                displaySeriesResults([]);
            }
        }
    };
    xhr.send('query=' + encodeURIComponent(searchTerm));
}, 300); // 300ms de délai

// On ajoute l'écouteur d'événement avec la fonction debounce
searchInputSeries.addEventListener('input', debouncedSearch);

// Fonction pour afficher les résultats
function displaySeriesResults(results) {
    searchResultsSeries.innerHTML = '';

    if (results.length > 0) {
        const table = document.createElement('table');
        results.forEach(function(result) {
            const tr = document.createElement('tr');
            const td = document.createElement('td');
            const link = document.createElement('a');
            link.textContent = result.titre;
            link.href = 'seriesdetails.php?id=' + encodeURIComponent(result.id);
            td.appendChild(link);
            tr.appendChild(td);
            table.appendChild(tr);
        });
        searchResultsSeries.appendChild(table);
    } else {
        const p = document.createElement('p');
        p.textContent = 'Aucun résultat trouvé.';
        searchResultsSeries.appendChild(p);
    }
}