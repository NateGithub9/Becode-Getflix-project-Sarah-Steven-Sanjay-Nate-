let limit = 12;

function loadMoreFilms() {
  limit += 12; // Augmenter le LIMIT de 12 à chaque clic
  const form = document.getElementById('film-filters-form');
  const formData = new FormData(form)

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "getallfilms.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      document.querySelector(".listefilms").innerHTML = xhr.responseText;
    }
  };
  xhr.send("limit=" + limit + "&" + new URLSearchParams(formData).toString());

}
