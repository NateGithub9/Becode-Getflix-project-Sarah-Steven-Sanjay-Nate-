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
        // On prépare la requête SQL qui recherche les films/ou séries dont le titre contient la valeur de $query
        $sql = "SELECT 'Film' AS type, titre, id FROM films WHERE titre LIKE '%" . $query . "%'
                UNION
                SELECT 'Serie' AS type, titre, id FROM series WHERE titre LIKE '%" . $query . "%'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // On formate les résultats en un tableau d'objets avec les propriétés 'titre' et 'id'
        echo json_encode(array_map(function($film) {
            return [
                'titre' => $film['titre'],
                'id' => $film['id'],
                'type' => $film['type']
            ];
        }, $results));
    } else {
        // Si la variable $query est vide, on renvoie un tableau vide
        echo json_encode([]);
    }
} else {
    // Si la variable $_POST['query'] n'est pas définie, on renvoie un tableau vide
    echo json_encode([]);
}
?>
