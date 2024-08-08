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

const searchInput = document.getElementById('searchInput');
const searchResults = document.getElementById('searchResults');

const debouncedSearch = debounce(function() {
    const searchTerm = searchInput.value.toLowerCase();

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'searchfilmsdb.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const results = JSON.parse(xhr.responseText);
            displayFilmsResults(results);
        }
    };

    xhr.send('query=' + encodeURIComponent(searchTerm));
}, 300); // 300ms de délai

searchInput.addEventListener('input', debouncedSearch);

function displayFilmsResults(results) {
    searchResults.innerHTML = '';
    const table = document.createElement('table');

    if (results.length > 0) {
        results.forEach(function(result) {
            const tr = document.createElement('tr');
            const link = document.createElement('a');
            link.textContent = escapeHtml(result.titre);
            link.href = 'filmsdetails.php?id=' + encodeURIComponent(result.id);
            tr.appendChild(link);
            table.appendChild(tr);
        });
    } else {
        const p = document.createElement('p');
        p.textContent = 'Aucun résultat trouvé.';
        searchResults.appendChild(p);
    }

    console.log(table);
    searchResults.appendChild(table);
}