document.addEventListener("DOMContentLoaded", function() {
    function addItemToList(type) {
        // Récupérer les informations du film ou de la série
        var title = document.querySelector('.seriestitle h2, .filmtitle h2').textContent.replace('Titre:', '').trim();
        var year = document.querySelector('.year h5').textContent.replace('Date de sortie:', '').trim();
        var language = document.querySelector('.language h5').textContent.replace('Langue originale:', '').trim();
        var note = document.querySelector('.note h5').textContent.replace('Note (/10) :', '').trim();

        var item = {
            type: type,
            title: title,
            year: year,
            language: language,
            note: note
        };

        var items = JSON.parse(localStorage.getItem('myList')) || [];

        // Vérifier si l'élément existe déjà dans la liste
        var existingItem = items.find(i => i.title === item.title && i.type === item.type);
        if (existingItem) {
            alert("Cet élément est déjà dans votre liste !");
            return;
        }

        items.push(item);

        localStorage.setItem('myList', JSON.stringify(items));

        alert("Bien ajouté à votre liste !");
        updateTable();
    }

    function updateTable() {
        var tableBody = document.querySelector('.myListTableBody');
        if (!tableBody) {
            console.log("Table body not found");
            return; // Si l'élément n'existe pas, on sort de la fonction
        }

        var items = JSON.parse(localStorage.getItem('myList')) || [];
        console.log(items);
        tableBody.innerHTML = ""; // Clear existing rows

        items.forEach(function(item, index) {
            var newRow = document.createElement('tr');

            var titleCell = document.createElement('td');
            titleCell.textContent = item.title;
            newRow.appendChild(titleCell);

            var yearCell = document.createElement('td');
            yearCell.textContent = item.year;
            newRow.appendChild(yearCell);

            var languageCell = document.createElement('td');
            languageCell.textContent = item.language;
            newRow.appendChild(languageCell);

            var noteCell = document.createElement('td');
            noteCell.textContent = item.note;
            newRow.appendChild(noteCell);

            var deleteCell = document.createElement('td');
            var deleteButton = document.createElement('button');
            deleteButton.textContent = "Supprimer";
            deleteButton.classList.add('btn', 'btn-danger');
            deleteButton.addEventListener('click', function() {
                deleteItem(index);
            });
            deleteCell.appendChild(deleteButton);
            newRow.appendChild(deleteCell);

            tableBody.appendChild(newRow);
        });
    }

    function deleteItem(index) {
        var items = JSON.parse(localStorage.getItem('myList')) || [];

        items.splice(index, 1);

        localStorage.setItem('myList', JSON.stringify(items));

        updateTable(); 
    }

    
    var addButton = document.querySelector('#addtomylist');
    if (addButton) {
        addButton.addEventListener('click', function() {
            var type = this.getAttribute('data-type');
            addItemToList(type);
        });
    }
    updateTable();
});