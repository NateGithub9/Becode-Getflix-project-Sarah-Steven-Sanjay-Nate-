<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails</title>
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

    <div class="container mt-4">
        <div class="row">
            <!-- IMAGE FILM/SERIE -->
            <div class="col-md-4">
                <div class="image">
                    <?php 
                    echo '<img src="https://media.themoviedb.org/t/p/w300_and_h450_bestv2/' . $result['image'] . '" alt="' . $result['titre'] . '" title="' . $result['titre'] . '">';
                    ?>
                </div>
            </div>
            <!-- FICHE DETAILS -->
            <div class="col-md-8">
                <div class="section-details">
                    <div class="contenu-details">
                        <div class="filmtitle">
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
                        <div class="description">
                            <p>
                            <?php
                                echo $result['description'];
                            ?>
                            </p>
                        </div>
                        <div class="note">
                            <h5>Note (/10) :
                            <?php
                                echo number_format($result['note'], 1);
                            ?>
                            </h5>
                        </div>
                        <div class="trailer">
                            <h5>Trailer:</h5>
                            <?php
                            if ($teaser === "Pas de trailer trouvé pour ce film.") {
                                echo 'Pas de trailers disponibles pour ce film.';
                            }
                            else {
                                echo '<iframe src="https://www.youtube.com/embed/' . $teaserKey . '" width="560" height="315" frameborder="0" allowfullscreen></iframe>';    
                            }  
                            ?>
                        </div>
                    </div>
                    <!-- AJOUT LISTE/B.A -->
                    <div class="boutons">
                        <button type="button" id="addtomylist" class="btn btn-primary" onclick="addItemToMyList()">Ajouter à ma liste</button>
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
                    <!-- Afficher les commentaires du film -->
                    <?php
                    include_once('./displaycomments.php');
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
    <script src="addtolist.js"></script>
</body>

</html>
