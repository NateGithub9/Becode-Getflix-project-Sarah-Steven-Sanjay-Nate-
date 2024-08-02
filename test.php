<?php 
include_once('./configdb.php');
include_once('./search.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Barre de recherche</title>
    <link rel="stylesheet" href="style.css">
    <style>
    </style>
</head>
<body>
    <input type="text" id="searchInput" placeholder="Rechercher...">
    <div id="searchResults">

    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');

        searchInput.addEventListener('input', function() {
            const searchTerm = searchInput.value.toLowerCase();
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'search.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    const results = JSON.parse(xhr.responseText);
                    displayResults(results);
                }
            };
            xhr.send('query=' + encodeURIComponent(searchTerm));
        });

        function displayResults(results) {
            searchResults.innerHTML = '';
            if (results.length > 0) {
                results.forEach(function(result) {
                const p = document.createElement('p');
                const link = document.createElement('a');
                link.href = 'filmsdetails.php?id=' + result.id; // Replace 'result.id' with the actual ID of the film
                link.textContent = result.titre; // Replace 'result.titre' with the actual title of the film
                p.classList.add('result');
                p.appendChild(link);
                searchResults.appendChild(p);
                });
            } else {
                const p = document.createElement('p');
                p.textContent = 'Aucun résultat trouvé.';
                searchResults.appendChild(p);
            }
        }

    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
</body>
</html>