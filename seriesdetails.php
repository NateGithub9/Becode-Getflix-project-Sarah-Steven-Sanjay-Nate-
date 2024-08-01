<?php
include_once('./configdb.php');
include_once('./accestoken.php');
// Récupérer l'id du film à partir de l'URL
$idSerie = $_GET['id'] ?? null;
// Récupérer les informations du film à partir de la base de données
$stmt = $db->prepare('SELECT * FROM series WHERE id = :id');
$stmt->execute(['id' => $idSerie]);
$result = $stmt->fetch();
//Récupérer le trailer du film à partir de l'api TMDB
$url = 'https://api.themoviedb.org/3/tv/' . $result["idexterne"] . '/videos?language=en-US';
$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => $url,
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
    ]
]);

$response3 = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

$data2 = json_decode($response3, true);
$results = $data2['results'];
$key = array_keys(array_filter($results, function ($item) {
    return $item['type'] === "Opening Credits";
}))[0] ?? null;
if ($key !== null) {
    $teaser = $results[$key];
    $teaserKey = htmlspecialchars($teaser['key'], ENT_QUOTES, 'UTF-8');
    $videoUrl = 'https://www.youtube.com/embed/' . $teaserKey;
} else {
    // handle the case where no matching element was found
    // for example, you could throw an exception or log an error
    $teaser = "Pas de trailers disponibles pour cette série.";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Streaming Website</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#"></a>
        <a href="index.php"><img src="images/logo.png" alt="logo" title="logo" width="180" height="39"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Accueil <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="films.php">Films</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="series.php">Séries</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="maliste.php">Ma Liste</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profil.php">Profil</a>
                </li>
            </ul>
        </div>
    </nav>
 
    <div class="container mt-4">
        <div class="row">
            <!-- IMAGE FILM/SERIE -->
            <div class="col-md-4">
                <div class="image">
                    <?php
                    echo '<img src="https://image.tmdb.org/t/p/w300_and_h450_bestv2/' . $result['image'] . '" alt="' . $result['titre'] . '" title="' . $result['titre'] . '">';
                    ?>
                </div>
            </div>
            <!-- FICHE DETAILS -->
            <div class="col-md-8">
                <div class="section-details">
                    <div class="contenu-details">
                        <div class="seriestitle">
                            <h2>Titre:
                            <?php 
                                echo $result['titre'];
                            ?>
                            </h2>
                        </div>
                
                        <div class="year">
                            <h5>Année: 
                            <?php 
                                echo $result['datesortie'];
                            ?>
                            </h5>
                        </div>
                        <div class="language">
                            <h5>Langue:
                            <?php
                                echo $result['langueoriginale'];
                            ?>
                            </h5>
                        </div>
                        <div class="description">
                            <p>
                            <?php
                                echo $result['description'];
                            ?>
                            </p>
                        </div>
                        <div class="trailer">
                            <h5>Trailer:</h5>
                            <?php
                            if ($teaser === "Pas de trailers disponibles pour cette série.") {
                                echo $teaser;
                            }
                            else {
                                echo '<iframe src="https://www.youtube.com/embed/' . $teaserKey . '" width="560" height="315" frameborder="0" allowfullscreen></iframe>';    
                            }  
                            ?>
                    </div>
                    <!-- AJOUT LISTE/B.A -->
                    <div class="boutons">
                        <button type="button" id="addtomylist" class="btn btn-primary" onclick="addItem()">Ajouter à ma liste</button>
                        <a href="trailer.php" class="btn btn-secondary">Voir la bande-annonce</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- COMMENTAIRES -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="section-commentaires">
                    <h3>Laisser un commentaire:</h3>
                        <form action="/submit-comment" method="POST">
                            <label for="comment"></label><br>
                            <textarea id="comment" name="comment" rows="4" cols="130" required></textarea><br><br>
                            <input type="submit" value="Commenter">
                        </form>
                    <br>
                    
                    <h3>Commentaires</h3>
                    <p>
                        
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
