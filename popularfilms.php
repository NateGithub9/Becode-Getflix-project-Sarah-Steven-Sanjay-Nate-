<?php
// Inclut le fichier de configuration de la base de données
include_once('./configdb.php');
include_once('./accestoken.php');

// Initialise une nouvelle session cURL
$curl = curl_init();

// Configure les options de la session cURL
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.themoviedb.org/3/movie/popular?language=fr-FR&page=1",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json',
        "accept: application/json"
    ],
]);

// Exécute la requête cURL et stocke la réponse dans une variable
$response = curl_exec($curl);
$err = curl_error($curl);

// Ferme la session cURL
curl_close($curl);

// Décode la réponse JSON en un tableau PHP
$data = json_decode($response, true);
$results = $data['results'];

// Vérifie si la table "popularfilms" est vide
$query = "SELECT COUNT(*) AS count FROM popularfilms";
$result = $db->query($query);
$row = $result->fetch(PDO::FETCH_ASSOC);
$count = $row['count'];

if ($count == 0) {
    // SI la table est vide, on ajoute les films récupérés (empêche les doublons)
    foreach ($results as $film) {
        $titre = stripslashes($film['title']);// On stocke le titre du film
        $description = stripslashes($film['overview']); // On stocke la description
        $image = $film['poster_path']; // On stocke l'image
    
        // Préparation de la requête SQL
        $sql = "INSERT INTO popularfilms (titre, description, image) VALUES (:titre, :description, :image)";
        $stmt = $db->prepare($sql);
    
        // Préparation des paramètres de la requête
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
    
        $stmt->execute();
        // Fermeture de la requête
        unset($stmt);
    }
}
// Récupère les 8 premiers films de la table "popularfilms"
$sql = "SELECT * FROM popularfilms LIMIT 8";
$stmt = $db->prepare($sql);
$stmt->execute();
$films = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Affiche les films dans une grille Bootstrap
echo '<div class="row">';
foreach ($films as $film) {
    echo '<div class="col-md-3 mt-3">';
    echo '<div class="thumbnail">';
    echo '<img src="https://media.themoviedb.org/t/p/w300_and_h450_bestv2/' . $film['image'] . '" alt="' . $film['titre'] . '">';
    echo '</div>';
    echo '</div>';
}
echo '</div>';
