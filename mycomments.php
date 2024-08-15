<?php
session_start();
include './configdb.php';
// Récupérer l'id de l'utilisateur et son rôle
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
// Récupérer le nouveau LIMIT depuis la requête GET
$status = isset($_GET['status']) ? $_GET['status'] : 'all';
$date = isset($_GET['date']) ? $_GET['date'] : '';

// Modifier le statut du commentaire si l'utilisateur est admin et qu'il a envoyé le formulaire de modification -> modération des commentaires
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['changeStatut'])) {
        $comment_id = $_POST['comment_id'];
        $comment_type = $_POST['comment_type'];

        if (isset($_POST['statut']) && is_array($_POST['statut'])) {
            $new_status = htmlspecialchars(strip_tags($_POST['statut'][$comment_id]), ENT_QUOTES, 'UTF-8');
        } else {
            $new_status = '';
        }

        $raison_refus = isset($_POST['raison_refus'][$comment_id]) ? htmlspecialchars(strip_tags($_POST['raison_refus'][$comment_id]), ENT_QUOTES, 'UTF-8') : null;

        $table = ($comment_type == 'Film') ? 'filmscomments' : 'seriescomments';
        $sql = "UPDATE $table SET statut = :statut, raison_refus = :raison_refus WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':statut', $new_status);
        $stmt->bindParam(':raison_refus', $raison_refus);
        $stmt->bindParam(':id', $comment_id);
        $stmt->execute();
        $_SESSION['messageupdatestatuts'] = "Le statut du commentaire a été mis à jour avec succès.";
    }
    header('Location: mycomments.php');
    exit();
}

// Requête SQL pour récupérer les commentaires de l'utilisateur
// Si l'utilisateur est admin, on récupère tous les commentaires
if ($role == 'admin') {
    $whereClause = "";
    if ($status != 'all') {
        $whereClause .= " AND statut = :status";
    }
    if (!empty($date)) {
        $whereClause .= " AND DATE(date_creation) = :date";
    }
    $sql = "(SELECT seriescomments.id, comment, titre, 'Série' as type, users.username, seriescomments.statut, seriescomments.date_creation, seriescomments.raison_refus 
    FROM seriescomments JOIN series ON seriescomments.idserie = series.id 
    JOIN users ON seriescomments.userid = users.id 
    $whereClause)
    UNION ALL
(SELECT filmscomments.id, comment, titre, 'Film' as type, users.username, filmscomments.statut, filmscomments.date_creation, filmscomments.raison_refus 
FROM filmscomments JOIN films ON filmscomments.idfilm = films.id 
JOIN users ON filmscomments.userid = users.id 
$whereClause)
";
    $stmt = $db->prepare($sql);
    if ($status != 'all') {
        $stmt->bindParam(':status', $status);
    }
    if (!empty($date)) {
        $stmt->bindParam(':date', $date);
    }
    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Si l'utilisateur n'est pas admin, on récupère les commentaires de l'utilisateur
    $whereClause = "WHERE userid = :userId";
    if ($status != 'all') {
        $whereClause .= " AND statut = :status";
    }
    if (!empty($date)) {
        $whereClause .= " AND DATE(date_creation) = :date";
    }

    $sql = "(SELECT seriescomments.id, comment, titre, 'Série' as type, seriescomments.statut, seriescomments.date_creation, seriescomments.raison_refus 
        FROM seriescomments 
        JOIN series ON seriescomments.idserie = series.id 
        $whereClause)
    UNION ALL
    (SELECT filmscomments.id, comment, titre, 'Film' as type, filmscomments.statut, filmscomments.date_creation, filmscomments.raison_refus 
        FROM filmscomments 
        JOIN films ON filmscomments.idfilm = films.id 
        $whereClause)";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':userId', $user_id);

    if ($status != 'all') {
        $stmt->bindParam(':status', $status);
    }
    if (!empty($date)) {
        $stmt->bindParam(':date', $date);
    }

    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                        <a class="nav-link active" aria-current="page" href="mycomments.php"><?php echo $role == 'admin' ? 'Tous les commentaires' : 'Mes commentaires'; ?></a>
                    </li>
                </ul>

                <div class="container-fluid1">
                    <?php
                    // Affichage du message de confirmation
                    if (isset($_SESSION['messageupdatestatuts'])) {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                ' . htmlspecialchars($_SESSION['messageupdatestatuts']) . '
                                <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                              </div>';
                        unset($_SESSION['messageupdatestatuts']);
                    }
                    ?>
                    <table id="commentsTable" class="table table-striped">
                        <thead>
                            <?php if ($role == 'admin') : ?>
                                <th><button class="sort-btn" data-sort="username">Utilisateur</button></th>
                            <?php endif; ?>
                            <th>
                                <div class="form-group">
                                    <label for="dateFilter">Filtrer par date :</label>
                                    <input type="date" id="dateFilter" class="form-control" name="dateFilter" value="<?php echo $date; ?>">
                                </div>
                                <button class="sort-btn" data-sort="date">Trier par date</button>
                            </th>
                            <th><button class="sort-btn" data-sort="type">Type</button></th>
                            <th><button class="sort-btn" data-sort="titre">Titre</button></th>
                            <th><button class="sort-btn" data-sort="comment">Commentaire</button></th>
                            <th><button class="sort-btn" data-sort="raison_refus">Modération</button></th>
                            <th>Actions</th>
                            <th>
                                <div class="form-group">
                                    <label for="statusFilter">Filtrer par statut :</label>
                                    <select id="statusFilter" class="form-control">
                                        <option value="all">Tous</option>
                                        <option value="En attente">En attente</option>
                                        <option value="Accepté">Accepté</option>
                                        <option value="Refusé">Refusé</option>
                                    </select>
                                </div>
                            </th>
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
                                echo "<td data-date='" . $comment['date_creation'] . "'>" . date('d-m-Y', strtotime($comment['date_creation'])) . "</td>";
                                // Affichage du type de commentaire
                                echo "<td>" . $comment['type'] . "</td>";
                                // Affichage du titre de la série ou du film
                                echo "<td>" . $comment['titre'] . "</td>";
                                // Affichage du commentaire
                                echo "<td class='comment-text'>" . $comment['comment'] . "</td>";
                                // Affichage de la raison de refus si le commentaire est refusé

                                echo "<td>" . ($comment['statut'] == 'Refusé' ? $comment['raison_refus'] : '') . "</td>";

                                // Affichage du bouton de suppression du commentaire
                                echo "<td><a href='deletecomment.php?id=" . $comment['id'] . "&type=" . $comment['type'] . "' class='btn btn-danger'>Supprimer</a></td>";
                                // Affichage du bouton de modification du statut du commentaire si l'utilisateur est admin
                                if ($role == 'admin') {
                                    echo "<td>
                                <form method='post' class='status-form'>
                                    <input type='hidden' name='comment_id' value='" . $comment['id'] . "'>
                                    <input type='hidden' name='comment_type' value='" . $comment['type'] . "'>
                                    <select name='statut[" . $comment['id'] . "]' class='status-select'>
                                        <option " . ($comment['statut'] == 'En attente' ? 'selected' : '') . " value='En attente'>En attente</option>
                                        <option " . ($comment['statut'] == 'Accepté' ? 'selected' : '') . " value='Accepté'>Accepté</option>
                                        <option " . ($comment['statut'] == 'Refusé' ? 'selected' : '') . " value='Refusé'>Refusé</option>
                                    </select>
                                    <textarea name='raison_refus[" . $comment['id'] . "]' class='form-control' placeholder='Raison de refus' value='" . htmlspecialchars($comment['raison_refus']) . "'></textarea>
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
    <script src="./sortcomments.js"></script>
    <script src="./showmorecomments.js"></script>
</body>

</html>