<?php
session_start();
include './configdb.php';
if (isset($_POST['email']) && isset($_POST['password'])) {
   $sql = "SELECT * FROM users WHERE email = :email AND password = :password"   ;
   $stmt = $db->prepare($sql);
   $stmt->bindParam(':email', $_POST['email']);
   $stmt->bindParam(':password', $_POST['password']);
   $stmt->execute();
   $user = $stmt->fetch();
   $_SESSION['user_id'] = $user['id'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes informations personnelles</title>
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
                <li class="nav-item">
                    <a class="nav-link" href="films.php">Films</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="series.php">Séries</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="profil.php">Profil <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>
<?php if (!isset($_SESSION['user_id'])) : ?>
    <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <form action="profil.php" method="post">
                            <h3 class="mb-5">Connecte-toi</h3>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="email" id="typeEmailX-2" class="form-control form-control-lg" name="email" />
                                <label class="form-label" for="typeEmailX-2">E-mail</label>
                            </div>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="password" id="typePasswordX-2" class="form-control form-control-lg" name="password" />
                                <label class="form-label" for="typePasswordX-2">Mot de passe</label>
                            </div>

                            <div class="form-check d-flex justify-content-start mb-4">
                                <input class="form-check-input" type="checkbox" value="" id="form1Example3" />
                                <label class="form-check-label" for="form1Example3"> Se rappeler du mot de passe </label>
                            </div>

                            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block" type="submit">Connexion</button>
                            </form>
                            <button class="btn btn-lg btn-block btn-secondary mt-2" style="background-color: #6c757d;" onclick="window.location.href='formulaireinscription.php'">Créer un compte</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else : ?>
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
                        <a class="nav-link" href="deconnexion.php">Déconnexion</a>
                    </li>
                </ul>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4 text-center">
                <img src="https://via.placeholder.com/250" alt="Avatar" class="rounded-circle img-fluid">
                <button type="submit" class="btn btn-primary">Changer mon avatar</button>
            </div>
            <div class="col-md-8">
                <h3>Mon compte</h3>
                <form>
                    <div class="form-group">
                        <label for="username">Nom d'utilisateur</label>
                        <input type="text" class="form-control" id="username" placeholder="Username" value="JohnDoe">
                    </div>                    
                    <div class="form-group">
                        <label for="email">Adresse e-mail</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter email" value="john.doe@example.com">
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de Passe</label>
                        <input type="password" class="form-control" id="password" placeholder="Password" value="password123">
                    </div>
                    <button type="submit" class="btn btn-primary">Changer mes informations</button>
                </form>
            </div>
        </div>
    </div>
<?php endif ?>
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