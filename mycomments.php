<?php
session_start();
include './configdb.php';
// Récupérer l'id de l'utilisateur et son rôle
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
// Récupérer le nouveau LIMIT depuis la requête GET
$limit = isset($_GET['limit']) ? $_GET['limit'] : 5;
$offset = isset($_GET['offset']) ? $_GET['offset'] : 5;

// Requête SQL pour récupérer les commentaires de l'utilisateur
// Si l'utilisateur est admin, on récupère tous les commentaires
if ($role == 'admin') {
    $sql = "(SELECT seriescomments.id, comment, titre, 'Série' as type, users.username, seriescomments.statut, seriescomments.date_creation FROM seriescomments JOIN series ON seriescomments.idserie = series.id JOIN users ON seriescomments.userid = users.id )
    UNION ALL
(SELECT filmscomments.id, comment, titre, 'Film' as type, users.username, filmscomments.statut, filmscomments.date_creation FROM filmscomments JOIN films ON filmscomments.idfilm = films.id JOIN users ON filmscomments.userid = users.id)
";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Si l'utilisateur n'est pas admin, on récupère les commentaires de l'utilisateur
    $sql = "(SELECT seriescomments.id, comment, titre, 'Série' as type, seriescomments.statut, seriescomments.date_creation FROM seriescomments JOIN series ON seriescomments.idserie = series.id WHERE userid = :userId)
    UNION ALL
(SELECT filmscomments.id, comment, titre, 'Film' as type, filmscomments.statut, filmscomments.date_creation FROM filmscomments JOIN films ON filmscomments.idfilm = films.id WHERE userid = :userId)
LIMIT :limit OFFSET :offset";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':userId', $user_id);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Modifier le statut du commentaire si l'utilisateur est admin et qu'il a envoyé le formulaire de modification -> modération des commentaires
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['changeStatut'])) {
    $comment_id = $_POST['comment_id'];
    $comment_type = $_POST['comment_type'];
    $new_status = htmlspecialchars(strip_tags($_POST['statut']), ENT_QUOTES, 'UTF-8');


    $table = ($comment_type == 'Film') ? 'filmscomments' : 'seriescomments';
    $sql = "UPDATE $table SET statut = :statut WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':statut', $new_status);
    $stmt->bindParam(':id', $comment_id);
    $stmt->execute();
    header('Location: mycomments.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Getflix - Mes commentaires</title>
    <link rel="icon" type="image/x-icon" href="images\getflix.ico">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="wrapper">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="#"></a>
            <a href="index.php"><img src="images/logoGetflix.png" alt="logo" title="logo" width="180" height="55"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Accueil </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="films.php">Films</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="series.php">Séries</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="profil.php">Profil<span class="sr-only">(current)</span></a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])) : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="deconnexion.php">Déconnexion</a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </nav>
        <div class="container-fluid">
            <div class="col-md-12 userdetails">
                <h2>Mes informations</h2>
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link" href="profil.php">Mes informations personnelles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="maliste.php">Ma liste</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="mycomments.php">Mes commentaires</a>
                    </li>
                </ul>

                <div class="container-fluid1">
                    <table id="commentsTable" class="table table-striped">
                        <thead>
                            <?php if ($role == 'admin') : ?>
                                <th><button class="sort-btn" data-sort="username">Utilisateur</button></th>
                            <?php endif; ?>
                            <th><button class="sort-btn" data-sort="date">Date</button></th>
                            <th><button class="sort-btn" data-sort="type">Type</button></th>
                            <th><button class="sort-btn" data-sort="titre">Titre</button></th>
                            <th><button class="sort-btn" data-sort="comment">Commentaire</button></th>
                            <th>Actions</th>
                            <th><button class="sort-btn" data-sort="statut">Statut</button></th>
                        </thead>
                        <tbody id="commentsTableBody">
                            <!-- Affichage des commentaires -->
                            <?php
                            foreach ($comments as $comment) {
                                echo "<tr>";
                                // Affichage de l'utilisateur si l'utilisateur est admin
                                if ($role == 'admin') {
                                    echo "<td>" . $comment['username'] . "</td>";
                                }
                                // Affichage de la date de création du commentaire
                                echo "<td>" . date('d-m-Y', strtotime($comment['date_creation'])) . "</td>";
                                // Affichage du type de commentaire
                                echo "<td>" . $comment['type'] . "</td>";
                                // Affichage du titre de la série ou du film
                                echo "<td>" . $comment['titre'] . "</td>";
                                // Affichage du commentaire
                                echo "<td>" . $comment['comment'] . "</td>";
                                // Affichage du bouton de suppression du commentaire
                                echo "<td><a href='deletecomment.php?id=" . $comment['id'] . "&type=" . $comment['type'] . "' class='btn btn-danger'>Supprimer</a></td>";
                                // Affichage du bouton de modification du statut du commentaire si l'utilisateur est admin
                                if ($role == 'admin') {
                                    echo "<td>
                                <form method='post' class='status-form'>
                                    <input type='hidden' name='comment_id' value='" . $comment['id'] . "'>
                                    <input type='hidden' name='comment_type' value='" . $comment['type'] . "'>
                                    <select name='statut' class='status-select'>
                                        <option " . ($comment['statut'] == 'En attente' ? 'selected' : '') . " value='En attente'>En attente</option>
                                        <option " . ($comment['statut'] == 'Accepté' ? 'selected' : '') . " value='Accepté'>Accepté</option>
                                        <option " . ($comment['statut'] == 'Refusé' ? 'selected' : '') . " value='Refusé'>Refusé</option>
                                    </select>
                                    <button type='submit' name='changeStatut' class='btn btn-primary btn-sm'>Modifier</button>
                                </form>
                            </td>";
                                } else {
                                    echo "<td>" . $comment['statut'] . "</td>";
                                }
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <div id="show-more-button">
                        <button id="loadMoreComments" class="btn btn-primary" type="submit" onclick="loadMoreComments()">Afficher plus de commentaires</button>
                    </div>
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
    <script src="./showmorecomments.js"></script>
    <script src="./sortcomments.js"></script>
</body>

</html>