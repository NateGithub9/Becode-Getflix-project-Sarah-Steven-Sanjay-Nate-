function addItem() {
    const item = document.getElementById('addToMyList').value;

    if (item) {
        let itemList = JSON.parse(localStorage.getItem('myPersonalList')) || [];

        itemList.push(item);

        localStorage.setItem('myPersonalList', JSON.stringify(itemList));

        document.getElementById('addToMyList').value = '';
    }
}

function displayItems() {

    const itemList = JSON.parse(localStorage.getItem('myPersonalList')) || [];

    const listElement = document.getElementById('myPersonalList');

    itemList.forEach(function(item) {
        const listItem = document.createElement('li');
        listItem.textContent = item;
        listElement.appendChild(listItem);
    });
}

window.onload = displayItems;