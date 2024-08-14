<?php
session_start();
include './configdb.php';
// Vérification et mise à jour du mot de passe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Vérifier si les champs du formulaire sont soumis
        if (isset($_POST['currentpassword']) && isset($_POST['newpassword']) && isset($_POST['confirmednewpassword'])) {
            $currentPassword = $_POST['currentpassword'];
            $newPassword = $_POST['newpassword'];
            $confirmedNewPassword = $_POST['confirmednewpassword'];
            // Vérification du nouveau mot de passe
            switch (!empty($newPassword)) {
                case strlen($newPassword) < 8: // Vérification de la longueur du mot de passe
                    $_SESSION['error'] = 'Le mot de passe doit contenir au moins 8 caractères.';
                    header("Location: updatepw.php");
                    exit();
                    break;
                case !preg_match('/[A-Z]/', $newPassword): // Vérification de la présence d'une lettre majuscule
                    $_SESSION['error'] = 'Le mot de passe doit contenir au moins une lettre majuscule.';
                    header("Location: updatepw.php");
                    exit();
                    break;
                case !preg_match('/[0-9]/', $newPassword): // Vérification de la présence d'un chiffre
                    $_SESSION['error'] = 'Le mot de passe doit contenir au moins un chiffre.';
                    header("Location: updatepw.php");
                    exit();
                    break;
                case !preg_match("/^[a-zA-Z0-9_\-!@#$%^&*()+=[\]{};:,.<>\/?|%\\\\]+$/", $password):
                    $_SESSION['error'] = 'Le mot de passe contient des caractères non autorisés.';
                    header("Location: updatepw.php");
                    exit();
                    break;
                case $newPassword !== $confirmedNewPassword: // Vérification des deux mots de passe
                    $_SESSION['error'] = 'Les mots de passe ne correspondent pas.';
                    header("Location: updatepw.php");
                    exit();
                    break;
            }

            // Vérifier si le mot de passe actuel est correct dans le cas ou l'utilisateur est connecté
            $sql = "SELECT password FROM users WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $_SESSION['user_id']);
            $stmt->execute();
            $user = $stmt->fetch();
            if (password_verify($currentPassword, $user['password'])) {
                // Mettre à jour le mot de passe dans la base de données
                $newPassword = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);
                $sql = "UPDATE users SET password = :newPassword WHERE id = :id";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':newPassword', $newPassword);
                $stmt->bindParam(':id', $_SESSION['user_id']);
                $stmt->execute();
                $_SESSION['success'] = 'Le mot de passe a été changé avec succès.';
                header('Location: profil.php');
                exit();
            } else {
                $_SESSION['error'] = 'Le mot de passe actuel est incorrect ou les nouveaux mots de passe ne correspondent pas.';
                header("Location: updatepw.php");
                exit();
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Getflix - Changer de mot de passe</title>
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
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <form action="updatepw.php" method="post">
                            <h3 class="mb-5">Changer de mot de passe</h3>
                            <?php if (!isset($_SESSION['user_id'])) : ?>
                                <div class="form-outline mb-4">
                                    <input type="email" id="typePasswordX-2" class="form-control form-control-lg" name="currentpassword" />
                                    <label class="form-label" for="typePasswordX-2">Votre adresse email</label>
                                </div>
                            <?php endif; ?>
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="password" id="typePasswordX-2" class="form-control form-control-lg" name="currentpassword" />
                                <label class="form-label" for="typePasswordX-2">Mot de passe actuel</label>
                            </div>
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="password" id="typePasswordX-2" class="form-control form-control-lg" name="newpassword" />
                                <label class="form-label" for="typePasswordX-2">Nouveau mot de passe</label>
                            </div>
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="password" id="typePasswordX-2" class="form-control form-control-lg" name="confirmednewpassword" />
                                <label class="form-label" for="typePasswordX-2">Confirmer le mot de passe</label>
                            </div>
                            <?php if (isset($_SESSION['error'])) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo htmlspecialchars($_SESSION['error']); ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php unset($_SESSION['error']); ?>
                            <?php endif; ?>
                            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block" type="submit">Changer mon mot de passe</button>
                        </form>
                    </div>
                </div>
            </div>
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