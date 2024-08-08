<?php
session_start();

include_once('./configdb.php');

// Vérification du jeton CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Erreur de sécurité");
}

// Récupération de l'ID et du type (film ou série) depuis la session
$itemID = $_SESSION['itemID'] ?? null;
$itemType = $_SESSION['itemType'] ?? null;

if (!$itemID || !$itemType) {
    die("Erreur : ID ou type non trouvé");
}

// Nettoyage et validation du commentaire
$comment = filter_input(INPUT_POST, 'comment', FILTER_UNSAFE_RAW);
$comment = strip_tags($comment);
if ($comment === false || $comment === '') {
    die("Commentaire invalide");
}

// Préparation de la requête en fonction du type
if ($itemType === 'film') {
    $stmt = $db->prepare("INSERT INTO filmscomments (idfilm, comment) VALUES (:itemID, :comment)");

} elseif ($itemType === 'serie') {
    $stmt = $db->prepare("INSERT INTO seriescomments (idserie, comment) VALUES (:itemID, :comment)");
} else {
    die("Type d'élément invalide");
}


// Insertion du commentaire dans la base de données
$stmt->execute([
    'itemID' => $itemID,
    'comment' => $comment
]);

// Redirection vers la page des détails appropriée
$redirectPage = ($itemType === 'film') ? 'filmsdetails.php' : 'seriesdetails.php';
header("Location: $redirectPage?id=" . $itemID);
exit();