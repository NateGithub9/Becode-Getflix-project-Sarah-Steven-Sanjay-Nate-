<?php
session_start();
// Inclusion du fichier de configuration de la base de données et de l'accès au token
include_once('./configdb.php');
include_once('./accestoken.php');

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Récupération de l'id de la série à partir de l'URL
$idSerie = $_GET['id'] ?? null;
$_SESSION['itemID'] = $idSerie;
$_SESSION['itemType'] = 'serie';

// Requête SQL pour récupérer les informations de la série à partir de la base de données
$stmt = $db->prepare('SELECT *, languages.name AS langue FROM series JOIN languages ON series.langueoriginale = languages.iso WHERE series.id = :id');
$stmt->execute(['id' => $idSerie]);
$result = $stmt->fetch();

// Récupération de l'URL de récupération des vidéos de la série à partir de l'API TMDB
$url = 'https://api.themoviedb.org/3/tv/' . $result["idexterne"] . '/videos?language=en-US';

// Initialisation d'une nouvelle session cURL
$curl = curl_init();

// Configuration des options de la session cURL
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true, // Indique que la réponse sera retournée comme une chaîne de caractères
    CURLOPT_ENCODING => "", // Indique que toutes les encodages sont autorisés
    CURLOPT_MAXREDIRS => 10, // Indique le nombre maximum de redirections
    CURLOPT_TIMEOUT => 30, // Indique le temps d'attente maximum pour la réponse
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, // Indique la version de l'HTTP utilisée
    CURLOPT_CUSTOMREQUEST => "GET", // Indique la méthode HTTP utilisée
    CURLOPT_HTTPHEADER => [ // Indique les en-têtes HTTP à envoyer avec la requête
        'Authorization: Bearer ' . $token, // Autorisation utilisée pour l'accès à l'API TMDB
        'Content-Type: application/json', // Type de contenu de la requête
        "accept: application/json" // Type de contenu de la réponse attendue
    ]
]);

// Exécution de la requête cURL et stockage de la réponse dans une variable
$response3 = curl_exec($curl);
$err = curl_error($curl);

// Fermeture de la session cURL
curl_close($curl);

// Décode la réponse JSON en un tableau PHP
$data2 = json_decode($response3, true);
$results = $data2['results'];

// Filtrage des éléments contenant un type de vidéo "Opening Credits" ou "Trailer" ou "Featurette"
$key = array_keys(array_filter($results, function ($item) {
    return $item['type'] === "Opening Credits" || $item['type'] === "Trailer" || $item['type'] === "Featurette";
}))[0] ?? null;

// Si un élément correspondant est trouvé
if ($key !== null) {
    // Récupération du lien YouTube de la vidéo
    $teaser = $results[$key];
    $teaserKey = htmlspecialchars($teaser['key'], ENT_QUOTES, 'UTF-8');
    $videoUrl = 'https://www.youtube.com/embed/' . $teaserKey;
} else {
    // Sinon, on indique qu'il n'y a pas de trailers disponibles
    $teaser = "Pas de trailers disponibles pour cette série.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails</title>
    <link rel="icon" type="image/x-icon" href="images\getflix.ico">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="details.css">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#"></a>
        <a href="index.php"><img src="images/logoGetflix.png" alt="logo" title="logo" width="180" height="55"></a>
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
                            <h5>Date de sortie: 
                            <?php 
                                echo date('d-m-Y', strtotime($result['datesortie']));
                            ?>
                            </h5>
                        </div>
                        <div class="language">
                            <h5>Langue originale:
                            <?php
                                echo $result['langue'];
                            ?>
                            </h5>
                        </div>
                        <div class="note">
                            <h5>Note (/10) :
                            <?php
                                echo $result['note'];
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
                            if ($teaser === "Pas de trailers disponibles pour cette série.") {
                                echo 'Pas de trailers disponibles pour cette série.';
                            }
                            else {
                                echo '<iframe src="https://www.youtube.com/embed/' . $teaserKey . '" width="560" height="315" frameborder="0" allowfullscreen></iframe>';    
                            }  
                            ?>
                    </div>
                    <!-- AJOUT LISTE/B.A -->
                    <div class="boutons">
                        <button type="button" id="addtomylist" class="btn btn-primary" onclick="addItem()">Ajouter à ma liste</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- COMMENTAIRES -->
        <div class="row mt-4">
            <div class="col-12">
                <?php if (isset($_SESSION['user_id'])) : ?>
                <div class="section-commentaires">
                    <h3>Laisser un commentaire:</h3>
                    <form action="./addcomments.php" method="POST" name="commentform">
                        <label for="comment">Votre commentaire :</label><br>
                        <textarea id="comment" name="comment" rows="4" cols="100" required maxlength="1000"></textarea><br><br>
                        <!-- Token CSRF pour la sécurité du formulaire -->
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="submit" value="Commenter" name="submit">
                    </form>
                <br>
                <?php endif; ?>
                    <h3>Commentaires</h3>
                    <?php
                    include './displaycomments.php';
                    ?>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        Website created by Sarah, Steven, Sanjay & Nate. Check out our source code!
        <a href="https://github.com/NateGithub9/Becode-Getflix-project-Sarah-Steven-Sanjay-Nate-" target="_blank"><img src="images/git.webp" width="50" height="50" alt="github icon"></a>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
