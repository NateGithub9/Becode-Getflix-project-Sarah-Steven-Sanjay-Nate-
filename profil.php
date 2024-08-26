<?php
session_start();
include './configdb.php';
// Si un mail et un mot de passe sont envoyés par le formulaire de connexion
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Vérification de l'existence de l'email dans la base de données
    $sql = "SELECT id, password, username, email, role FROM users WHERE email = :email";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Mot de passe correct, démarrer la session utilisateur
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header("Location: profil.php");
        exit();
    } else {
        // Mot de passe incorrect ou utilisateur non trouvé
        $_SESSION['error'] = "Email ou mot de passe incorrect.";
        header("Location: profil.php");
        exit();
    }
}
// Récupérer les informations de l'utilisateur
$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Si un formulaire de mise à jour des informations est envoyé
if (isset($_POST['updateinfos'])) {
    if (!empty($_POST['username'])) {
        $stmt = $db->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->bindParam(':username', $_POST['username']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) { // Si l'username est déjà utilisé
            $_SESSION['error'] = "Le nom d'utilisateur est déjà utilisé.";
            header("Location: profil.php");
            exit();
        }
        // Validation de l'username pour autoriser les lettres, les chiffres, les tirets, les underscores et certains caractères spéciaux
        if (!preg_match("/^[a-zA-Z0-9@_\-]+$/", $_POST['username'])) {
            $_SESSION['error'] = "Le nom d'utilisateur contient des caractères non autorisés.";
            header("Location: profil.php");
            exit();
        }
    }
    // Vérification de l'existence de l'email dans la base de données
    if (!empty($_POST['email'])) {
        $stmt = $db->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) { // Si l'email est déjà utilisé
            $_SESSION['error'] = "L'adresse email est déjà utilisée.";
            header("Location: profil.php");
            exit();
        }
    }
    // Mettre à jour les informations de l'utilisateur dans la base de données
    $sql = "UPDATE users SET username = :username, email = :email WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username', $_POST['username']);
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->bindParam(':id', $_SESSION['user_id']);
    $stmt->execute();
    $_SESSION['success'] = "Vos informations ont été mises à jour avec succès.";
    header("Location: profil.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if (isset($_SESSION['user_id'])) : echo 'Getflix - Mes informations personnelles';
            else : echo 'Getflix - Connexion';
            endif; ?></title>
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
                <li class="nav-item">
                    <a class="nav-link" href="films.php">Films</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="series.php">Séries</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="profil.php">Profil <span class="sr-only">(current)</span></a>
                </li>
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="deconnexion.php">Déconnexion</a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    </nav>
    <?php if (!isset($_SESSION['user_id'])) : ?>
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <?php
                            if (isset($_SESSION['error'])) {
                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                ' . htmlspecialchars($_SESSION['error']) . '
                                <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                              </div>';
                                unset($_SESSION['error']);
                            }
                            if (isset($_SESSION['success'])) {
                                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                ' . htmlspecialchars($_SESSION['success']) . '
                                <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                              </div>';
                                unset($_SESSION['success']);
                            }
                            ?>
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
                    <!--<li class="nav-item">
                        <a class="nav-link" href="maliste.php">Ma liste</a>
                    </li>-->
                    <li class="nav-item">
                        <a class="nav-link" href="mycomments.php"><?php echo $_SESSION['role'] == 'admin' ? 'Tous les commentaires' : 'Mes commentaires'; ?></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-4 text-center">
                    <?php if (isset($_SESSION['messageupdateavatar'])) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo htmlspecialchars($_SESSION['messageupdateavatar']); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?php unset($_SESSION['messageupdateavatar']); ?>
                    <?php endif; ?>
                    <img src="<?php if (isset($user['avatar']) && $user['avatar'] != 'https://via.placeholder.com/250') {
                                    echo './avatars/' . $user['avatar'];
                                } else {
                                    echo 'https://via.placeholder.com/250';
                                }
                                ?>" alt="Avatar" class="rounded-circle img-fluid">
                    <form action="changeavatar.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="avatar" id="avatar">
                        <button type="submit" class="btn btn-primary">Changer mon avatar</button>
                    </form>
                </div>
                <div class="col-md-8">
                    <?php
                    if (isset($_SESSION['success'])) {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    ' . htmlspecialchars($_SESSION['success']) . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                        unset($_SESSION['success']);
                    }
                    if (isset($_SESSION['error'])) {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ' . htmlspecialchars($_SESSION['error']) . '
                        <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
                            <span aria-hidden="true">&times;</span>
                        </button>
                      </div>';
                        unset($_SESSION['error']);
                    }
                    ?>
                    <h3>Mon compte</h3>
                    <form action="profil.php" method="post">
                        <div class="form-group">
                            <label for="username">Nom d'utilisateur</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $user['username']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Adresse e-mail</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="<?php echo $user['email']; ?>">
                        </div>
                        <div class="form-group">
                            <a href="updatepw.php">Changer mon mot de passe</a>
                        </div>
                        <button type="submit" class="btn btn-primary" name="updateinfos">Changer mes informations</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endif ?>
    <footer class="footer">
        Website created by Sarah, Steven, Sanjay & Nate. Check out our source code!
        <a href="https://github.com/NateGithub9/Becode-Getflix-project-Sarah-Steven-Sanjay-Nate-" target="_blank"><img src="images/git.webp" width="50" height="50" alt="github icon"></a>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>