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
const searchInputHomePage = document.getElementById('searchInputHomePage');
const searchResultsHomePage = document.getElementById('searchResultsHomePage');

// Fonction de recherche avec debounce
const debouncedSearch = debounce(function() {
    const searchTermHomePage = searchInputHomePage.value.toLowerCase();

    if (searchTermHomePage.length < 2) {
        searchResultsHomePage.innerHTML = '';
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'searchalldb.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    const results = JSON.parse(xhr.responseText);
                    displayAllResults(results);
                } catch (e) {
                    console.error('Erreur lors du parsing JSON:', e);
                    displayAllResults([]);
                }
            } else {
                console.error('Erreur de requête:', xhr.status);
                displayAllResults([]);
            }
        }
    };

    xhr.send('query=' + encodeURIComponent(searchTermHomePage));
}, 300); // 300ms de délai

// On ajoute l'écouteur d'événement avec la fonction debounce
searchInputHomePage.addEventListener('input', debouncedSearch);

// Fonction pour afficher les résultats
function displayAllResults(results) {
    searchResultsHomePage.innerHTML = '';

    if (results.length > 0) {
        const table = document.createElement('table');
        results.forEach(function(result) {
            const tr = document.createElement('tr');
            const td = document.createElement('td');
            const link = document.createElement('a');
            
            const baseUrl = result.type === 'Film' ? 'filmsdetails.php' : 'seriesdetails.php';
            
            link.textContent = escapeHtml(result.titre);
            link.href = baseUrl + '?id=' + encodeURIComponent(result.id);
            
            td.appendChild(link);
            tr.appendChild(td);
            table.appendChild(tr);
        });
        searchResultsHomePage.appendChild(table);
    } else {
        const p = document.createElement('p');
        p.textContent = 'Aucun résultat trouvé.';
        searchResultsHomePage.appendChild(p);
    }
}