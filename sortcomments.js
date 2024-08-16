document.addEventListener("DOMContentLoaded", function () {
  const statusFilter = document.getElementById("statusFilter");
  const dateFilter = document.getElementById("dateFilter");
  const commentsTableBody = document.getElementById("commentsTableBody");
  const rows = Array.from(commentsTableBody.querySelectorAll("tr"));

  let sortOrders = {
    username: true,
    date: true,
    type: true,
    titre: true,
    comment: true,
    raison_refus: true,
    statut: true,
  };

  function formatDate(dateString) {
    if (!dateString) return "";
    if (/^\d{4}-\d{2}-\d{2}$/.test(dateString)) return dateString;

    const parts = dateString.split(/[-/]/);
    if (parts.length !== 3) return dateString;

    let [day, month, year] =
      parts[0].length === 4 ? [parts[2], parts[1], parts[0]] : parts;
    year = year.length === 2 ? "20" + year : year;

    return `${year}-${month.padStart(2, "0")}-${day.padStart(2, "0")}`;
  }

  function filterComments() {
    const selectedStatus = statusFilter.value;
    const selectedDate = dateFilter.value;

    const urlParams = new URLSearchParams(window.location.search);

    if (selectedStatus && selectedStatus !== "all") {
      urlParams.set("status", selectedStatus);
    } else {
      urlParams.delete("status");
    }

    if (selectedDate) {
      urlParams.set("date", selectedDate);
    } else {
      urlParams.delete("date");
    }

    // Rediriger avec tous les paramètres
    window.location.href = '?' + urlParams.toString();
  }

  function getColumnIndex(columnName) {
    return Array.from(document.querySelectorAll("th")).findIndex((header) => {
      const button = header.querySelector(".sort-btn");
      return button && button.dataset.sort === columnName;
    });
  }

  function sortTable(column) {
    const columnIndex = getColumnIndex(column);
    rows.sort((a, b) => {
      let valueA = a.querySelector(`td:nth-child(${columnIndex + 1})`);
      let valueB = b.querySelector(`td:nth-child(${columnIndex + 1})`);

      if (column === "statut") {
        valueA = valueA.querySelector(".status-select")?.value || "";
        valueB = valueB.querySelector(".status-select")?.value || "";
      } else {
        valueA = valueA?.textContent.trim() || "";
        valueB = valueB?.textContent.trim() || "";
      }

      if (!valueA && !valueB) return 0;
      if (!valueA) return 1;
      if (!valueB) return -1;

      return sortOrders[column]
        ? valueA.localeCompare(valueB, undefined, { sensitivity: "base" })
        : valueB.localeCompare(valueA, undefined, { sensitivity: "base" });
    });

    rows.forEach((row) => commentsTableBody.appendChild(row));
    sortOrders[column] = !sortOrders[column];
  }

  function toggleRaisonRefus(selectElement) {
    const raisonRefusInput = selectElement.nextElementSibling;
    raisonRefusInput.style.display =
      selectElement.value === "Refusé" ? "inline-block" : "none";
  }

  // Initialiser les filtres avec les valeurs de l'URL
  const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('status')) {
      statusFilter.value = urlParams.get('status');
    }
    if (urlParams.has('date')) {
      dateFilter.value = urlParams.get('date');
    }

  // Initialiser les filtres avec les valeurs de l'URL au chargement de la page
statusFilter.addEventListener("change", filterComments);
dateFilter.addEventListener("change", filterComments);

document.querySelectorAll(".status-select").forEach((select) => {
    toggleRaisonRefus(select);
    select.addEventListener("change", () => toggleRaisonRefus(select));
  });
  
  document.querySelectorAll(".sort-btn").forEach((button) => {
    button.addEventListener("click", () => sortTable(button.dataset.sort));
  });
});
