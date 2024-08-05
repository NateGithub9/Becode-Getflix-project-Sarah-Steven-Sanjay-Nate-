<?php

include './configdb.php';
include './accestoken.php';

$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://api.themoviedb.org/3/configuration/languages",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => [
    'Authorization: Bearer ' . $token,
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
    
    foreach ($data as $language) {
      $codeiso = $language['iso_639_1'];
      $name = $language['english_name'];
  
      $sqlCheck = "SELECT COUNT(*) FROM languages WHERE name = :name";
      $stmtCheck = $db->prepare($sqlCheck);
      $stmtCheck->bindParam(':name', $name);
      $stmtCheck->execute();
      $count = $stmtCheck->fetchColumn();

      // Préparation de la requête SQL
      if ($count == 0) {
        $sql = "INSERT INTO languages (name, iso) VALUES (:name, :codeiso)";
        $stmt = $db->prepare($sql);

        // Préparation des paramètres de la requête
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':codeiso', $codeiso);
        $stmt->execute();
        // Fermeture de la requête
        unset($stmt);
      }
    }
  }

//Affichage des languages depuis la base de données
$sql = "SELECT * FROM languages WHERE name <> 'french' ORDER BY name ASC";; //La langue "FRENCH" est renomée manuellement en "FRANCAIS" dans la base de données. "French" qui n'existe donc pas et qui veut être ajouté doit être exclu de la liste.
$stmt = $db->prepare($sql);
$stmt->execute();
$languages = $stmt->fetchAll();

foreach ($languages as $language) {
    $name = $language['name'];
    $codeiso = $language['iso'];
    echo '<option value="' . $codeiso . '">' . $name . '</option>';
  }



  
  
