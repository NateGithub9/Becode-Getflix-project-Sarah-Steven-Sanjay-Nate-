<?php
// Démarrer une session pour gérer les messages d'erreur ou de succès
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
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm-password']);

    // Vérification des mots de passe
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
        header("Location: inscription.php");
        exit();
    }

    // Hachage du mot de passe pour la sécurité
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Préparation de la requête pour éviter les injections SQL
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    // Exécuter la requête
    if ($stmt->execute()) {
        $_SESSION['success'] = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
        header("Location: connexion.php");
    } else {
        $_SESSION['error'] = "Une erreur est survenue lors de l'inscription.";
        header("Location: inscription.php");
    }

    // Fermer la requête et la connexion
    $stmt->close();
    $conn->close();
} else {
    $_SESSION['error'] = "Accès non autorisé.";
    header("Location: inscription.php");
}
?>
