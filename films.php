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
    <div class="listefilms1">
        <h1>Liste des films</h1>
    </div>
    <div class="search">
        <form class="form-inline justify-content-center mt-4">
            <input id="searchInput" class="form-control mr-2" name="searchInput" type="search" placeholder="Recherchez votre film">
            <button class="btn btn-primary" type="submit">Recherche</button>
        </form>
    </div>
    <div name="searchResults" id="searchResults">

    </div>
    <div class="listefilms">
        <?php
        include_once('./getallfilms.php');
        ?>     
    </div>

    <button id="show-more-button" class="btn btn-primary" type="submit" onclick="loadMoreFilms()">Afficher plus de films</button>

    <div class="filters">
        <h2>Filtres</h2>
        <form class="form-inline" id="film-filters-form" method="POST">
            <label for="langue">Langue originale:</label>
            <select name="langue" id="langue" class="form-control">
                <option value="" selected>Toutes les langues</option>
                <?php
                include_once('./getlanguages.php');
                ?>
            </select>
            <label for="note">Note:</label>
            <input type="range" name="note" class="form-control-range note" min="0" max="10" step="1">
            <span class="currentNoteValue"></span>
            <label for="datesortie">Date de sortie:</label>
            <div class="datesortie">
                <label for="datesortiedebut">De:</label>
                <input type="date" name="datesortiedebut" class="form-control datesortiedebut">
                <label for="datesortiefin">À:</label>
                <input type="date" name="datesortiefin"  class="form-control datesortiefin">
            </div>
            <button class="btn btn-primary button-for-filters" type="submit">Recherche</button>
        </form>
    </div>

    <footer class="footer">
        Website created by Sarah, Steven, Sanjay & Nate. Check out our source code!
        <a href="https://github.com/NateGithub9/Becode-Getflix-project-Sarah-Steven-Sanjay-Nate-" target="_blank"><img src="images/git.webp" width="50" height="50" alt="github icon"></a>
    </footer>
    <script src="./searchfilms.js"></script>
    <script src="./displaynote.js"></script>
    <script src="./showmore.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>