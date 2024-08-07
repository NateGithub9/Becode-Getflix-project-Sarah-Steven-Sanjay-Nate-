<?php
// On inclut le fichier de configuration de la base de données
include_once('./configdb.php');

// Définir le type de contenu de la réponse comme JSON
header('Content-Type: application/json');

// Initialiser la variable $query
$query = '';

// On vérifie si la variable $_POST['query'] est définie et non vide
if (isset($_POST['query']) && !empty($_POST['query'])) {
    // On nettoie la valeur de $query pour éviter les injections XSS
    $query = htmlspecialchars($_POST['query'], ENT_QUOTES, 'UTF-8');

    try {
        // On prépare la requête SQL en utilisant un paramètre lié pour éviter les injections SQL
        $sql = "SELECT titre, id FROM series WHERE titre LIKE :query";
        $stmt = $db->prepare($sql);
        
        // On lie le paramètre en ajoutant les caractères % pour la recherche partielle
        $stmt->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
        
        $stmt->execute();

        // On récupère les résultats de la requête SQL dans un tableau
        $series = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // On renvoie directement le tableau de résultats
        echo json_encode($series);
    } catch (PDOException $e) {
        // En cas d'erreur, on renvoie un message d'erreur générique
        // et on log l'erreur réelle pour le débogage
        error_log('Erreur de base de données : ' . $e->getMessage());
        echo json_encode(['error' => 'Une erreur est survenue lors de la recherche.']);
    }
} else {
    // Si la variable $_POST['query'] n'est pas définie ou vide, on renvoie un tableau vide
    echo json_encode([]);
}
?>