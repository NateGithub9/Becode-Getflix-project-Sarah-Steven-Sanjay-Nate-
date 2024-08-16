<?php
session_start();
include 'configdb.php';
// Vérifie si les paramètres 'id' et 'type' sont définis dans l'URL
if (isset($_GET['id']) && isset($_GET['type'])) {
    // Récupère l'identifiant du commentaire et le type (Film ou Série)
    $id = $_GET['id'];
    $type = $_GET['type'];

    // Détermine la table à partir du type (Film ou Série)
    if ($type == 'Film') {
        $table = 'filmscomments';
    } else if ($type == 'Série') {
        $table = 'seriescomments';
    }

    // Prépare et exécute la requête SQL pour supprimer le commentaire de la table correspondante
    $sql = "DELETE FROM $table WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $_SESSION['message'] = "Le commentaire a été supprimé avec succès.";
    // Redirige vers la page 'mycomments.php' après la suppression du commentaire
    header('Location: mycomments.php');
    exit();
}
?>