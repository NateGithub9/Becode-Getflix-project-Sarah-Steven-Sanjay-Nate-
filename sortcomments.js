// Début de la Sélection
// Ce code s'exécute lorsque le contenu de la page est entièrement chargé
document.addEventListener('DOMContentLoaded', function() {
    // Sélection de la table des commentaires et de son corps
    const table = document.getElementById('commentsTable');
    const tbody = table.querySelector('tbody');
    // Sélection de tous les boutons de tri
    const sortButtons = document.querySelectorAll('.sort-btn');

    // Initialisation du tri actuel
    let currentSort = { column: null, ascending: true };

    // Pour chaque bouton de tri
    sortButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Récupération de la colonne associée au bouton
            const column = button.dataset.sort;
            
            // Vérification si la colonne est déjà triée
            if (column === currentSort.column) {
                currentSort.ascending = !currentSort.ascending;
            } else {
                currentSort = { column: column, ascending: true };
            }

            // Récupération des lignes du tableau
            const rows = Array.from(tbody.querySelectorAll('tr'));

            // Tri des lignes en fonction de la colonne sélectionnée
            rows.sort((a, b) => {
                let aValue, bValue;

                // Récupération des valeurs à comparer dans les cellules de la ligne
                if (column === 'statut') {
                    // Pour la colonne statut, on récupère la valeur sélectionnée dans un menu déroulant
                    aValue = a.querySelector(`td:nth-child(${getColumnIndex(column)}) select`)?.value || a.querySelector(`td:nth-child(${getColumnIndex(column)})`).textContent.trim();
                    bValue = b.querySelector(`td:nth-child(${getColumnIndex(column)}) select`)?.value || b.querySelector(`td:nth-child(${getColumnIndex(column)})`).textContent.trim();
                } else {
                    // Pour les autres colonnes, on récupère le texte brut des cellules
                    aValue = a.querySelector(`td:nth-child(${getColumnIndex(column)})`).textContent.trim();
                    bValue = b.querySelector(`td:nth-child(${getColumnIndex(column)})`).textContent.trim();
                }

                // Comparaison des valeurs en fonction du tri actuel
                return currentSort.ascending 
                    ? aValue.localeCompare(bValue, 'fr', { sensitivity: 'base' })
                    : bValue.localeCompare(aValue, 'fr', { sensitivity: 'base' });
            });

            // Réinitialisation du contenu du corps du tableau avec les lignes triées
            tbody.innerHTML = '';
            rows.forEach(row => tbody.appendChild(row));

            // Mise à jour des indicateurs visuels de tri
            updateSortIndicators(button);
        });
    });

    // Fonction pour obtenir l'index de la colonne à partir du nom de la colonne
    function getColumnIndex(columnName) {
        const headers = Array.from(table.querySelectorAll('th'));
        return headers.findIndex(header => {
            const button = header.querySelector('.sort-btn');
            return button && button.dataset.sort.toLowerCase() === columnName.toLowerCase();
        }) + 1;
    }

    // Fonction pour mettre à jour les indicateurs visuels de tri
    function updateSortIndicators(activeButton) {
        sortButtons.forEach(btn => {
            btn.classList.remove('asc', 'desc');
        });
        activeButton.classList.add(currentSort.ascending ? 'asc' : 'desc');
    }
});
// Fin de la Sélection