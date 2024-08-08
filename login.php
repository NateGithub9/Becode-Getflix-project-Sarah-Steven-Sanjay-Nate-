<?php
session_start();

// Connexion à la base de données
$servername = "db"; // Nom du service Docker pour la base de données
$username_db = "test";
$password_db = "pass";
$dbname = "GetflixDB";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Vérification que le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Préparation de la requête pour récupérer l'utilisateur
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Vérification que l'utilisateur existe
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $hashed_password);
        $stmt->fetch();

        // Vérification du mot de passe
        if (password_verify($password, $hashed_password)) {
            // Stocker les informations de l'utilisateur dans la session
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "Connexion réussie !";

            // Rediriger vers index.php avec un paramètre pour afficher un message pop-up
            header("Location: index.php?login=success");
            exit();
        } else {
            $_SESSION['error'] = "Mot de passe incorrect.";
            // Rediriger vers la même page avec une erreur
            header("Location: profil.php?login=failed");
            exit();
        }
    } else {
        $_SESSION['error'] = "Aucun compte trouvé avec cette adresse email.";
        // Rediriger vers la même page avec une erreur
        header("Location: profil.php?login=failed");
        exit();
    }

    // Fermer la requête et la connexion
    $stmt->close();
    $conn->close();
}
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
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Connexion</a>
                
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
            <footer class="footer">
                Website created by Sarah, Steven, Sanjay & Nate. Check out our source code!
                <a href="https://github.com/NateGithub9/Becode-Getflix-project-Sarah-Steven-Sanjay-Nate-" target="_blank"><img src="images/git.webp" width="50" height="50" alt="github icon"></a>
            </footer>
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
