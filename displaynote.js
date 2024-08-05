// Début de la Sélection
// Sélectionner tous les éléments avec la classe "note"
const rangeElements = document.querySelectorAll(".note");
// Sélectionner tous les éléments avec la classe "currentNoteValue"
const currentValueElements = document.querySelectorAll(".currentNoteValue");

// Pour chaque élément de la liste rangeElements
rangeElements.forEach((range, index) => {
    // Ajouter un écouteur d'événements pour l'entrée
    range.addEventListener("input", function () {
        // Mettre à jour le contenu textuel de l'élément correspondant dans currentValueElements
        currentValueElements[index].textContent = range.value;
    });
});
// Fin de la Sélection