<?php
include 'configdb.php';
// Vérification que le formulaire a été soumis
if (isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm-password']);

    // Vérification des mots de passe
    if ($password !== $confirm_password) {
        // Stocker le message d'erreur dans la session
        $_SESSION['error'] = 'Les mots de passe ne correspondent pas.';
        header("Location: formulaireinscription.php");
        exit();
    }


    // Vérification de l'existence de l'email dans la base de données
    $stmt = $db->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $stmt->fetch();
    if ($stmt->rowCount() > 0) {
        $_SESSION['error'] = "L'adresse email est déjà utilisée.";
        header("Location: formulaireinscription.php");
        exit();
    }

    // Hachage du mot de passe pour la sécurité
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Préparation de la requête pour éviter les injections SQL
    $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);

    // Exécuter la requête
    if ($stmt->execute()) {
        $_SESSION['success'] = "Inscription réussie ! Bienvenue, $username.";
        $_SESSION['user_id'] = $db->lastInsertId(); // ID de l'utilisateur nouvellement créé
        $_SESSION['username'] = $username; // Stocker le nom d'utilisateur dans la session
        header("Location: profil.php?welcome=1");
        exit();
    } else {
        $_SESSION['error'] = "Une erreur est survenue lors de l'inscription.";
        header("Location: formulaireinscripton.php");
        exit();
    }

    // Fermer la requête et la connexion
    $stmt->close();
    $conn->close();
} else {
    // Si la méthode de la requête n'est pas POST, redirigez vers la page d'inscription
    header("Location: formulaireinscription.php");
    exit();
}
?>