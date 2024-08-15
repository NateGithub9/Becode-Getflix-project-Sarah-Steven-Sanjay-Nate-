<?php
session_start();
include './configdb.php';
// 
$user_id = $_SESSION['user_id'];


// Récupération des paramètres
$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;
$offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 5;
$status = isset($_GET['status']) ? $_GET['status'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : '';

$where = "";

if ($status) {
    $where .= " AND statut = :status";
}
if ($date) {
    $where .= " AND date_creation = :date";
}


// Préparation et exécution de la requête
$stmt = $db->prepare("(SELECT seriescomments.id, comment, titre, 'Série' as type, seriescomments.statut, seriescomments.date_creation, seriescomments.raison_refus 
FROM seriescomments JOIN series ON seriescomments.idserie = series.id 
WHERE userid = :userId $where)
UNION ALL
(SELECT filmscomments.id, comment, titre, 'Film' as type, filmscomments.statut, filmscomments.date_creation, filmscomments.raison_refus 
FROM filmscomments JOIN films ON filmscomments.idfilm = films.id 
WHERE userid = :userId $where)
LIMIT :limit OFFSET :offset ");
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':userId', $user_id, PDO::PARAM_INT);
if ($status) {
    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
}
if ($date) {
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
}
$stmt->execute();

// Génération du HTML
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>
    <td>" . date('d/m/Y', strtotime($row['date_creation'])) . "</td>
    <td>" . htmlspecialchars($row['type']) . "</td>
    <td>" . htmlspecialchars($row['titre']) . "</td>
    <td class='comment-text'>" . htmlspecialchars($row['comment']) . "</td>
    <td>" . ($row['statut'] == 'Refusé' ? $row['raison_refus'] : '') . "</td>
    <td><a href='deletecoment.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-danger'>Supprimer</a> </td>
    <td>" . $row['statut'] . "</td>
    </tr>";
};
