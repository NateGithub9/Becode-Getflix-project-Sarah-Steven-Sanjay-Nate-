<?php

include_once('./configdb.php');
include_once('./accestoken.php');

// Nombre total de pages à récupérer
$totalPages = 10;

// URL de base pour la requête
$baseUrl = "https://api.themoviedb.org/3/discover/movie?language=fr-FR&sort_by=popularity.desc&adult=false&";



// Effectuer la requête pour chaque page
for ($page = 1; $page <= $totalPages; $page++) {
  $curl = curl_init();

  curl_setopt_array($curl, [
    CURLOPT_URL => $baseUrl . "&page=" . $page,
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

  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    $data = json_decode($response, true);
    $results = $data['results'];

    foreach ($results as $film) {
      $idExterne = $film['id'];
      $titre = $film['title'];
      $description = $film['overview'];
      $image = $film['poster_path'];
      $datesortie = $film['release_date'];
      $langueorigine = $film['original_language'];

      $sqlCheck = "SELECT COUNT(*) FROM films WHERE titre = :titre";
      $stmtCheck = $db->prepare($sqlCheck);
      $stmtCheck->bindParam(':titre', $titre);
      $stmtCheck->execute();
      $count = $stmtCheck->fetchColumn();

      // Préparation de la requête SQL
      if ($count == 0) {
        $sql = "INSERT INTO films (titre, description, image, idexterne, datesortie, langueoriginale) VALUES (:titre, :description, :image, :idexterne, :datesortie, :langueorigine)";
        $stmt = $db->prepare($sql);

        // Préparation des paramètres de la requête
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':datesortie', $datesortie);
        $stmt->bindParam(':idexterne', $idExterne);
        $stmt->bindParam(':langueorigine', $langueorigine);
        $stmt->execute();
        // Fermeture de la requête
        unset($stmt);
      }
    }
  }

  //Selecitonner tous les fims dans la base de données
  $db = new PDO('mysql:host=db;dbname=GetflixDB', 'test', 'pass');
  $sql = "SELECT * FROM films WHERE image IS NOT NULL";
  $stmt = $db->prepare($sql);
  $stmt->execute();
  $films = $stmt->fetchAll();

  foreach ($films as $film) {
    $id = $film['id'];
    $titre = $film['titre'];
    $description = $film['description'];
    echo '<div class="col-md-3 mt-3">';
    echo '<div class="card" style="width: 18rem;">';
    echo '<a href="./filmsdetails.php?id=' . $id . '"><img src="https://media.themoviedb.org/t/p/w300_and_h450_bestv2/' . $film['image'] . '" class="card-img-top" alt="' . $film['titre'] . '"></a>';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">' . $titre . '</h5>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
  }
}
