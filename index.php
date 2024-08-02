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
        <a href="index.php"> <img src="images/logo.png" alt="logo" title="logo" width="180" height="39"></a>
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

    <div class="container">
        <div id="featuredCarousel" class="carousel slide featured" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://via.placeholder.com/1500x500" class="d-block w-100" alt="First slide">
                    <div class="carousel-caption d-flex flex-column justify-content-end align-items-center">
                        <h1>Sélectionnés pour vous</h1>

                    </div>
                </div>
                <div class="carousel-item">
                    <img src="https://via.placeholder.com/1500x500" class="d-block w-100" alt="Second slide">
                    <div class="carousel-caption d-flex flex-column justify-content-end align-items-center">
                        <h1>Sélectionnés pour vous</h1>
                        
                    </div>
                </div>
            </div>
            <!-- Ajout du Carrousel -->
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
                <input class="form-control mr-2" id="searchInputHomePage" type="search" placeholder="Recherchez votre film, série,...">
                <button class="btn btn-primary" type="submit">Recherche</button>
            </form>
        </div>
        <div id="searchResultsHomePage">

        </div>
        <h2>Populaires</h2>

            <?php 
                include_once('./popularfilms.php');
            ?>

        <h2 class="mt-5">Nouveaux</h2>

            <?php 
                include_once('./latestfilms.php');
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