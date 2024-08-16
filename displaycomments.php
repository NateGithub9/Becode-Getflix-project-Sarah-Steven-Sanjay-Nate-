<?php
//Inclusion de la configuration de la base de données
include_once('./configdb.php');
//Récupération des données de la session
$itemID = $_SESSION['itemID'] ?? null; //Récupération de l'id de l'item
$itemType = $_SESSION['itemType'] ?? null; //Récupération du type de l'item

//Vérification des paramètres
if (!isset($db) || !isset($itemID) || !isset($itemType)) {
    die("Erreur : Paramètres manquants");
}

// Sélection de la table appropriée
$table = ($itemType === 'film') ? 'filmscomments' : 'seriescomments';
//Définition de la colonne appropriée
$idColumn = ($itemType === 'film') ? 'idfilm' : 'idserie';

//Requête SQL pour récupérer les commentaires
$sql = "SELECT username, comment, statut
        FROM $table
        JOIN users ON $table.userid = users.id
        WHERE $idColumn = :itemID AND statut = 'Accepté'" ;

$stmt = $db->prepare($sql);
//Exécution de la requête avec l'id de l'item
$stmt->execute(['itemID' => $itemID]);
//Récupération des commentaires
$comments = $stmt->fetchAll();
?>

<?php if (count($comments) > 0) : //Si il y a des commentaires ?> 
    <?php foreach ($comments as $comment) :
         //Boucle pour afficher les commentaires ?>
         <?php if ($comment['statut'] == 'Accepté') {
            echo "<p>" . $comment['username'] . " a commenté : " . $comment['comment'] . "</p>";
         }
         ?>
    <?php endforeach; ?>
<?php else : ?>
    <p>Aucun commentaire pour le moment.</p>
<?php endif; ?>