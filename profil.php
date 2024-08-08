<?php
session_start();

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
    // L'utilisateur est connecté, afficher les informations de profil
    $username = $_SESSION['username'];
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Getflix - Profil</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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

        <div class="container-fluid">
            <div class="col-md-12 userdetails">
                <h2>Mes informations</h2>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="profil.php">Mes informations personnelles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="maliste.php">Ma liste</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mycomments.php">Mes commentaires</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
            </div>
        </div>

        <footer class="footer">
            Website created by Sarah, Steven, Sanjay & Nate. Check out our source code!
            <a href="https://github.com/NateGithub9/Becode-Getflix-project-Sarah-Steven-Sanjay-Nate-" target="_blank"><img src="images/git.webp" width="50" height="50" alt="github icon"></a>
        </footer>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>

    <?php
} else {
    // L'utilisateur n'est pas connecté, afficher le formulaire de connexion
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Getflix - Connexion</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
        <script>
            window.onload = function() {
                <?php if (isset($_GET['login']) && $_GET['login'] == 'failed'): ?>
                    alert("L'authentification a échoué. Veuillez vérifier votre email et votre mot de passe.");
                <?php endif; ?>
            };
        </script>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
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

        <section class="vh-100" style="background-color: #111;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card shadow-2-strong" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center">

                                <h3 class="mb-5">Connecte-toi</h3>

                                <?php
                                if (isset($_SESSION['error'])) {
                                    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                                    unset($_SESSION['error']);
                                }

                                if (isset($_SESSION['success'])) {
                                    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                                    unset($_SESSION['success']);
                                }
                                ?>

                                <form method="POST" action="">
                                    <div class="form-outline mb-4">
                                        <input type="email" id="typeEmailX-2" name="email" class="form-control form-control-lg" required />
                                        <label class="form-label" for="typeEmailX-2">E-mail</label>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="password" id="typePasswordX-2" name="password" class="form-control form-control-lg" required />
                                        <label class="form-label" for="typePasswordX-2">Mot de passe</label>
                                    </div>

                                    <div class="form-check d-flex justify-content-start mb-4">
                                        <input class="form-check-input" type="checkbox" value="" id="form1Example3" />
                                        <label class="form-check-label" for="form1Example3"> Se rappeler du mot de passe </label>
                                    </div>

                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Connexion</button>
                                </form>

                                <hr class="my-4">

                                <!-- Bouton Inscription -->
                                <button class="btn btn-lg btn-block btn-secondary mt-2" style="background-color: #6c757d;" onclick="window.location.href='formulaireinscription.php'">Créer un compte</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="footer">
            Website created by Sarah, Steven, Sanjay & Nate. Check out our source code!
            <a href="https://github.com/NateGithub9/Becode-Getflix-project-Sarah-Steven-Sanjay-Nate-" target="_blank"><img src="images/git.webp" width="50" height="50" alt="github icon"></a>
        </footer>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>

    <?php
}
?>
