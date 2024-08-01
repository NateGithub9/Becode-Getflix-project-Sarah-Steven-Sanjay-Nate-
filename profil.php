<?php



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
    <!--<div class="login-container">
        <h2>Login</h2>
        <form action="/login" method="post">
            <label for="email">Adresse e-mail:</label>
            <input type="text" id="email" name="email" required>

            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" value="Login">
        </form>
    </div>
    <div class="new-account-container">
        <h2>Nouveau compte</h2>
        <form action="/login" method="post">

            <label for="email">Adresse e-mail:</label>
            <input type="text" id="new-mail" name="email" required>

            <label for="password">Mot de passe:</label>
            <input type="text" id="password" name="password" required>

            <input type="submit" value="Créer">

        </form>

    </div>-->
    <section class="vh-100" style="background-color: #111;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <h3 class="mb-5">Connecte-toi</h3>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="email" id="typeEmailX-2" class="form-control form-control-lg" />
                                <label class="form-label" for="typeEmailX-2">E-mail</label>
                            </div>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="password" id="typePasswordX-2" class="form-control form-control-lg" />
                                <label class="form-label" for="typePasswordX-2">Mot de passe</label>
                            </div>

                            <!-- Checkbox -->
                            <div class="form-check d-flex justify-content-start mb-4">
                                <input class="form-check-input" type="checkbox" value="" id="form1Example3" />
                                <label class="form-check-label" for="form1Example3"> Se rappeler du mot de passe </label>
                            </div>

                            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block" type="submit">Connexion</button>

                            <hr class="my-4">

                            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-lg btn-block btn-primary" style="background-color: #dd4b39;" type="submit"><i class="fab fa-google me-2"></i> Se connecter avec Google</button>
                            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-lg btn-block btn-primary mb-2" style="background-color: #3b5998;" type="submit"><i class="fab fa-facebook-f me-2"></i>Se connecter avec Facebook</button>

                        </div>
                    </div>
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