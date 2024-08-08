<?php
session_start();

// Connexion à la base de données
$servername = "db";  // Utilisez 'db' car c'est le nom du service MySQL dans Docker
$username_db = "test";  // Utilisateur de la base de données
$password_db = "pass";  // Mot de passe de la base de données
$dbname = "GetflixDB";  // Nom de la base de données

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

    // Vérification de l'existence de l'email dans la base de données
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "L'adresse email est déjà utilisée.";
        header("Location: inscription.php");
        exit();
    }
    $stmt->close();

    // Hachage du mot de passe pour la sécurité
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Préparation de la requête pour éviter les injections SQL
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    // Exécuter la requête
    if ($stmt->execute()) {
        $_SESSION['success'] = "Inscription réussie ! Bienvenue, $username.";
        $_SESSION['user_id'] = $stmt->insert_id; // ID de l'utilisateur nouvellement créé
        $_SESSION['username'] = $username; // Stocker le nom d'utilisateur dans la session
        header("Location: profil.php?welcome=1");
        exit();
    } else {
        $_SESSION['error'] = "Une erreur est survenue lors de l'inscription.";
        header("Location: inscription.php");
        exit();
    }

    // Fermer la requête et la connexion
    $stmt->close();
    $conn->close();
} else {
    // Si la méthode de la requête n'est pas POST, redirigez vers la page d'inscription
    header("Location: inscription.php");
    exit();
}
?>
