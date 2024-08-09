<?php

include_once('./configdb.php');
include_once('./accestoken.php');

// Nombre total de pages à récupérer
$totalPages = 1;

// URL de base pour la requête
$baseUrl = "https://api.themoviedb.org/3/discover/tv?language=fr-FR&sort_by=popularity.desc&include_adult=false";


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

    foreach ($results as $serie) {
      $idExterne = $serie['id'];
      $titre = $serie['original_name'];
      $description = $serie['overview'];
      $image = $serie['poster_path'];
      $datesortie = $serie['first_air_date'];
      $langueorigine = $serie['original_language'];
      $note = $serie['vote_average'];

      

      $sqlCheck = "SELECT COUNT(*) FROM series WHERE titre = :titre";
      $stmtCheck = $db->prepare($sqlCheck);
      $stmtCheck->bindParam(':titre', $titre);
      $stmtCheck->execute();
      $count = $stmtCheck->fetchColumn();

      // Préparation de la requête SQL
      if ($count == 0) {
        $sql = "INSERT INTO series (titre, description, image, idexterne, datesortie, langueoriginale, note) VALUES (:titre, :description, :image, :idexterne, :datesortie, :langueorigine, :note)";
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

// Récupération des filtres
$langue = isset($_POST['langue']) ? $_POST['langue'] : null;
$note = isset($_POST['note']) ? $_POST['note'] : null;
$dateDebut = !empty($_POST['datesortiedebut']) ? $_POST['datesortiedebut'] : '';
$dateFin = !empty($_POST['datesortiefin']) ? $_POST['datesortiefin'] : '';
$tri = isset($_POST['tri']) ? $_POST['tri'] : null;

// Récupération du LIMIT dynamique
$limit = isset($_POST['limit']) ? intval($_POST['limit']) : 12;
$offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;

//Requête SQL de base
$sql = "SELECT * FROM series WHERE image IS NOT NULL";

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

//Ajout des filtres à la requête SQL
switch ($tri) {
  case "note":
    $sql .= " ORDER BY note ASC";
   break;
  case "notedesc":
    $sql .= " ORDER BY note DESC";
    break;
  case "date":
     $sql .= " ORDER BY datesortie ASC";
    break;
  case "datedesc":
    $sql .= " ORDER BY datesortie DESC";
    break;
  case "titre":
   $sql .= " ORDER BY titre ASC";
   break;
  case "titredesc":
    $sql .= " ORDER BY titre DESC";
    break;
  default:
    break;
}

//Ajout de la limite et de l'offset à la requête SQL
$sql .= " LIMIT :limit OFFSET :offset";

//Préparation de la requête SQL
$stmt = $db->prepare($sql);

// Si la langue est sélectionnée, on prépare le paramètre de la requête SQL
if (!empty($langue)) {
  $stmt->bindParam(':langue', $langue, PDO::PARAM_STR);
}

// Si la note est sélectionnée, on prépare le paramètre de la requête SQL
if (!empty($note)) {
  $stmt->bindParam(':note', $note, PDO::PARAM_INT);
}
//Si la date de début et de fin est sélectionnée, on prépare le paramètre de la requête SQL
if (!empty($dateDebut) && !empty($dateFin)) {
  $stmt->bindParam(':datesortiedebut', $dateDebut, PDO::PARAM_STR);
  $stmt->bindParam(':datesortiefin', $dateFin, PDO::PARAM_STR);
}
//Si la limite est sélectionnée, on prépare le paramètre de la requête SQL
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

// Exécution de la requête SQL
$stmt->execute();

// Récupération des résultats
$series = $stmt->fetchAll();


// Afficher les séries dans la page
foreach ($series as $serie) { //Boucle pour afficher les séries dans la page
  $id = $serie['id']; //Récupérer l'id de la série
  $titre = $serie['titre']; //Récupérer le titre de la série
  $description = $serie['description']; //Récupérer la description de la série
  $image = $serie['image']; //Récupérer l'image de la série
  $datesortie = $serie['datesortie']; //Récupérer la date de sortie de la série
  $langueorigine = $serie['langueoriginale']; //Récupérer la langue originale de la série
  $note = $serie['note']; //Récupérer la note de la série

  echo '<div class="col-md-3 mt-3">'; //Créer une colonne de 3 pour les séries
  echo '<div class="card" style="width: 18rem;">'; //Créer une carte de 18rem pour les séries
  echo '<a href="./seriesdetails.php?id=' . $id . '"><img src="https://media.themoviedb.org/t/p/w300_and_h450_bestv2/' . $serie['image'] . '" class="card-img-top" alt="' . $serie['titre'] . '"></a>'; //Créer un lien vers la page des détails de la série  
  echo '<div class="card-body">'; //Créer le corps de la carte
  echo '<h5 class="card-title">' . $titre . '</h5>'; //Afficher le titre de la série
  echo '</div>'; //Fermer le corps de la carte  
  echo '</div>'; //Fermer la carte
  echo '</div>'; //Fermer la colonne
}