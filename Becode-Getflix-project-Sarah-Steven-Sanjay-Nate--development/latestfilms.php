<?php
include_once('./configdb.php');
include_once ('./accestoken.php');

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.themoviedb.org/3/movie/now_playing?language=fr-FR&page=1",
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

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

$data = json_decode($response, true);
$results = $data['results'];

$query = "SELECT COUNT(*) AS count FROM newfilms";
$result = $db->query($query);
$row = $result->fetch(PDO::FETCH_ASSOC);
$count = $row['count'];

if ($count == 0) {
    // The films table is empty, so include the populatedb.php file
    foreach ($results as $film) {
        $titre = stripslashes($film['title']);
        $description = stripslashes($film['overview']);
        $image = $film['poster_path'];
    
        // Préparation de la requête SQL
        $sql = "INSERT INTO newfilms (titre, description, image) VALUES (:titre, :description, :image)";
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



$sql = "SELECT * FROM newfilms LIMIT 8";
$stmt = $db->prepare($sql);
$stmt->execute();
$films = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<div class="row">';
foreach ($films as $film) {
    echo '<div class="col-md-3 mt-3">';
    echo '<div class="thumbnail">';
    echo '<img src="https://media.themoviedb.org/t/p/w300_and_h450_bestv2/' . $film['image'] . '" alt="' . $film['titre'] . '">';
    echo '</div>';
    echo '</div>';
}
echo '</div>';
