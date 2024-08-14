<?php
session_start();
include './configdb.php';
// 
$user_id = $_SESSION['user_id'];

// Récupération des paramètres
$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;
$offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 5;
error_log("Limit: $limit, Offset: $offset");

// Préparation et exécution de la requête
$stmt = $db->prepare("(SELECT seriescomments.id, comment, titre, 'Série' as type, seriescomments.statut FROM seriescomments JOIN series ON seriescomments.idserie = series.id WHERE userid = :userId)
UNION ALL
(SELECT filmscomments.id, comment, titre, 'Film' as type, filmscomments.statut FROM filmscomments JOIN films ON filmscomments.idfilm = films.id WHERE userid = :userId)
LIMIT :limit OFFSET :offset ");
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':userId', $user_id, PDO::PARAM_INT);
$stmt->execute();

// Génération du HTML
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>
    <td>" . htmlspecialchars($row['type']) . "</td>
    <td>" . htmlspecialchars($row['titre']) . "</td>
    <td>" . htmlspecialchars($row['comment']) . "</td>
    <td><a href='deletecoment.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-danger'>Supprimer</a> </td>
    <td>" . $row['statut'] . "</td>
    </tr>";
};

