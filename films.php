<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Getflix</title>
    <link rel="icon" type="image/x-icon" href="images\getflix.ico">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
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
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Accueil</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="films.php">Films <span class="sr-only">(current)</span></a>
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
    <div class="listefilms1">
        <h1>Liste des films</h1>
    </div>
    <div class="searchbarfilms">
        <form class="form-inline justify-content-center mt-4">                
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
            </svg>
            <div class="search-container">
                <input id="searchInput" class="form-control mr-2" name="searchInput" type="search" placeholder="Recherchez votre film">
                <div name="searchResults" id="searchResults"></div>
            </div>
        </form>
    </div>


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 filters">
                <h2>Filtres</h2>
                <form class="form-inline filters-form" method="POST">
                    <label for="tri">Trier par:</label>
                    <select name="tri" id="tri" class="form-control">
                        <option value="" <?php echo (!isset($_POST['tri']) || $_POST['tri'] == "") ? 'selected' : ''; ?>>Trier par</option>
                        <option value="notedesc" <?php echo (isset($_POST['tri']) && $_POST['tri'] == "notedesc") ? 'selected' : ''; ?>>Note (Décroissant)</option>
                        <option value="note" <?php echo (isset($_POST['tri']) && $_POST['tri'] == "note") ? 'selected' : ''; ?>>Note (Croissant)</option>
                        <option value="datedesc" <?php echo (isset($_POST['tri']) && $_POST['tri'] == "datedesc") ? 'selected' : ''; ?>>Date (+ ancien)</option>
                        <option value="date" <?php echo (isset($_POST['tri']) && $_POST['tri'] == "date") ? 'selected' : ''; ?>>Date (+ récent)</option>
                        <option value="titredesc" <?php echo (isset($_POST['tri']) && $_POST['tri'] == "titredesc") ? 'selected' : ''; ?>>Titre (de Z à A)</option>
                        <option value="titre" <?php echo (isset($_POST['tri']) && $_POST['tri'] == "titre") ? 'selected' : ''; ?>>Titre (de A à Z)</option>
                    </select>
                    <label for="langue">Langue originale:</label>
                    <select name="langue" id="langue" class="form-control">
                        <option value="" <?php if (!isset($_POST['langue']) || $_POST['langue'] == "") echo "selected"; ?>>Toutes les langues</option>
                        <?php
                        include_once('./getlanguages.php');
                        if (isset($_POST['langue'])) {
                            $selectedLangue = $_POST['langue'];
                            echo "<script>document.getElementById('langue').value = '$selectedLangue';</script>";
                        }
                        ?>
                    </select>
                    <div class="note-container">
                        <label for="note">Note:</label>
                        <input type="range" name="note" class="form-control-range note" min="0" max="10" step="1" value="<?php echo isset($_POST['note']) ? $_POST['note'] : '0'; ?>">
                        <span class="currentNoteValue"><?php echo isset($_POST['note']) ? $_POST['note'] : '0'; ?></span>
                    </div>
                    <label for="datesortie">Date de sortie:</label>
                    <div class="datesortie">
                        <div class="datesortiedebut">
                            <label for="datesortiedebut">De:</label>
                            <input type="date" name="datesortiedebut" class="form-control datesortiedebut" value="<?php echo isset($_POST['datesortiedebut']) ? $_POST['datesortiedebut'] : ''; ?>">
                        </div>
                        <div class="datesortiefin">
                            <label for="datesortiefin">À:</label>
                            <input type="date" name="datesortiefin" class="form-control datesortiefin" value="<?php echo isset($_POST['datesortiefin']) ? $_POST['datesortiefin'] : ''; ?>">
                        </div>
                    </div>
                    <div class="filtersearchbutton">
                        <button class="btn btn-primary button-for-filters" type="submit">Recherche</button>
                    </div>
                </form>
            </div>
            <div class="col-md-10 listefilms">
                <?php
                include_once('./getallfilms.php');
                ?>
            </div>
        </div>
        <div id="show-more-button">
            <button class="btn btn-primary" type="submit" onclick="loadMoreItems('films')">Afficher plus de films</button>
        </div>
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