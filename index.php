<?php
session_start();
include_once('./configdb.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Getflix</title>
    <link rel="icon" type="image/x-icon" href="images\getflix.ico">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#"></a>
        <a href="index.php"> <img src="images/logoGetflix.png" alt="logo" title="logo" width="180" height="55"></a>
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
                <?php if (isset($_SESSION['user_id'])) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="deconnexion.php">Déconnexion</a>
                </li>
                <?php endif ?>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div id="featuredCarousel" class="carousel slide featured" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="images\carouselmontage.png" class="d-block w-100" alt="First slide">
                    <div class="carousel-caption d-flex flex-column justify-content-end align-items-center">
                </div>
                </div>
                <div class="carousel-item">
                    <img src="images\carouselmontage1.png" class="d-block w-100" alt="Second slide">
                    <div class="carousel-caption d-flex flex-column justify-content-end align-items-center">
                        
                        
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#featuredCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#featuredCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <div class="searchbar">
            <form class="form-inline justify-content-center mt-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                </svg>
                <div class="search-container">
                    <input class="form-control mr-2" id="searchInputHomePage" type="search" placeholder="Recherchez votre film, série,...">
                    <div id="searchResultsHomePage"></div>
                </div>
            </form>
        </div>
        <div id="searchResultsHomePage" class="search-results-item">

        </div>
        <h2>Populaires</h2>
            <?php 
                $sql = "SELECT * FROM films LIMIT 8";
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $films = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo '<div class="row">';
                foreach ($films as $film) {
                    echo '<div class="col-md-3 mt-3">';
                    echo '<div class="thumbnail">';
                    echo '<a href="filmsdetails.php?id=' . $film['id'] . '"><img src="https://media.themoviedb.org/t/p/w300_and_h450_bestv2/' . $film['image'] . '" alt="' . $film['titre'] . '"></a>';
                    echo '</div>';
                    echo '</div>';  
                }
                echo '</div>';
            ?>
    </div>
    <footer class="footer">
        Website created by Sarah, Steven, Sanjay & Nate. Check out our source code!
        <a href="https://github.com/NateGithub9/Becode-Getflix-project-Sarah-Steven-Sanjay-Nate-" target="_blank"><img src="images/git.webp" width="50" height="50" alt="github icon"></a>
    </footer>
    <script src="./searchall.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>