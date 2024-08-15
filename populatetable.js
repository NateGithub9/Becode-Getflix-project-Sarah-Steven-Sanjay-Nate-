document.addEventListener("DOMContentLoaded", function() {
    function addItemToList() {
        var title = "<?php echo $result['titre']; ?>";
        var year = "<?php echo date('d-m-Y', strtotime($result['datesortie'])); ?>";
        var language = "<?php echo $result['langue']; ?>";
        var note = "<?php echo number_format($result['note'], 1); ?>";

        var item = {
            title: title,
            year: year,
            language: language,
            note: note
        };

        var items = JSON.parse(localStorage.getItem('myList')) || [];

        items.push(item);

        localStorage.setItem('myList', JSON.stringify(items));

        alert("Bien ajouté à votre liste!");

        updateTable();
    }

    function updateTable() {
        var items = JSON.parse(localStorage.getItem('myList')) || [];

        var tableBody = document.querySelector('#myListTable tbody');
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
        addButton.addEventListener('click', addItemToList);
    }

    updateTable();
});
