<?php

include_once('./configdb.php');
include_once('./accestoken.php');

// Nombre total de pages à récupérer
$totalPages = 1;

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
      $note = $film['vote_average'];

      $sqlCheck = "SELECT COUNT(*) FROM films WHERE titre = :titre";
      $stmtCheck = $db->prepare($sqlCheck);
      $stmtCheck->bindParam(':titre', $titre);
      $stmtCheck->execute();
      $count = $stmtCheck->fetchColumn();

      // Préparation de la requête SQL
      if ($count == 0) {
        $sql = "INSERT INTO films (titre, description, image, idexterne, datesortie, langueoriginale, note) VALUES (:titre, :description, :image, :idexterne, :datesortie, :langueorigine, :note)";
        $stmt = $db->prepare($sql);

        // Préparation des paramètres de la requête
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':datesortie', $datesortie);
        $stmt->bindParam(':idexterne', $idExterne);
        $stmt->bindParam(':langueorigine', $langueorigine);
        $stmt->bindParam(':note', $note);
        $stmt->execute();
        // Fermeture de la requête
        unset($stmt);
      }
    }
  }
}
//Récupération des filtres
$langue = isset($_POST['langue']) ? $_POST['langue'] : null;
$note = isset($_POST['note']) ? $_POST['note'] : null;
$dateDebut = !empty($_POST['datesortiedebut']) ? $_POST['datesortiedebut'] : '';
$dateFin = !empty($_POST['datesortiefin']) ? $_POST['datesortiefin'] : '';

// Récupération du LIMIT dynamique
$limit = isset($_POST['limit']) ? intval($_POST['limit']) : 12;
$offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;

//Requête SQL de base
$sql = "SELECT * FROM films WHERE image IS NOT NULL";

//Ajout des filtres à la requête SQL
//Si la langue est sélectionnée, on ajoute la condition à la requête SQL
if (!empty($langue)) {
  $sql .= " AND langueoriginale = :langue";
}
//Si la note est sélectionnée, on ajoute la condition à la requête SQL
if (!empty($note)) {
  $sql .= " AND note >= :note";
}
//Si la date de début et de fin sont sélectionnées, on ajoute la condition à la requête SQL
if (!empty($dateDebut) && !empty($dateFin)) {
  $sql .= " AND datesortie BETWEEN :datesortiedebut AND :datesortiefin";
}
//Ajout de la limite et de l'offset à la requête SQL
$sql .= " LIMIT :limit OFFSET :offset";


//Préparation de la requête SQL
$stmt = $db->prepare($sql);

// Si la langue est sélectionnée, on prépare le paramètre de la requête SQL
if ($langue) {
  $stmt->bindParam(':langue', $langue, PDO::PARAM_STR);
}

// Si la note est sélectionnée, on prépare le paramètre de la requête SQL
if ($note) {
  $stmt->bindParam(':note', $note, PDO::PARAM_INT);
}
//Si la date de début et de fin est sélectionnée, on prépare le paramètre de la requête SQL
if ($dateDebut && $dateFin) {
  $stmt->bindParam(':datesortiedebut', $dateDebut, PDO::PARAM_STR);
  $stmt->bindParam(':datesortiefin', $dateFin, PDO::PARAM_STR);
}
//Si la limite est sélectionnée, on prépare le paramètre de la requête SQL
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
//Si l'offset est sélectionnée, on prépare le paramètre de la requête SQL
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
// Exécution de la requête SQL
$stmt->execute();

// Récupération des résultats
$films = $stmt->fetchAll();


//Affichage des films
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

