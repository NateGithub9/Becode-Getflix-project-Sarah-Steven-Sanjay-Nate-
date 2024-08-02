<?php
// On inclut le fichier de configuration de la base de données
include_once('./configdb.php');

// On vérifie si la variable $_POST['query'] est définie
// Si oui, on récupère la valeur de cette variable et on l'assigne à $query
if (isset($_POST['query'])) {
    $query = $_POST['query'];

    // On vérifie si la variable $query n'est pas vide
    // Si elle n'est pas vide, on exécute une requête SQL
    if (!empty($query)) {
        // On prépare la requête SQL qui recherche les films dont le titre contient la valeur de $query
        $sql = "SELECT titre, id FROM series WHERE titre LIKE '%" . $query . "%'";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        // On récupère les résultats de la requête SQL dans un tableau
        $series = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // On formate les résultats en un tableau d'objets avec les propriétés 'titre' et 'id'
        echo json_encode(array_map(function($serie) {
            return [
                'titre' => $serie['titre'],
                'id' => $serie['id']
            ];
        }, $series));
    } else {
        // Si la variable $query est vide, on renvoie un tableau vide
        echo json_encode([]);
    }
} else {
    // Si la variable $_POST['query'] n'est pas définie, on renvoie un tableau vide
    echo json_encode([]);
}
?>
