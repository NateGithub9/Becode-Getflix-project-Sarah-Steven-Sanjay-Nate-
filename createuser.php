<?php
session_start();
include 'configdb.php';

// Vérification que le formulaire a été soumis
if (isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm-password']);


    // Vérification longeur et complexité du mot de passe + vérification des deux mots de passe
    switch (!empty($password)) {
        case strlen($password) < 8: // Vérification de la longueur du mot de passe
            $_SESSION['error'] = 'Le mot de passe doit contenir au moins 8 caractères.';
            header("Location: formulaireinscription.php");
            exit();
            break;
        case !preg_match('/[A-Z]/', $password): // Vérification de la présence d'une lettre majuscule
            $_SESSION['error'] = 'Le mot de passe doit contenir au moins une lettre majuscule.';
            header("Location: formulaireinscription.php");
            exit();
            break;
        case !preg_match('/[0-9]/', $password): // Vérification de la présence d'un chiffre
            $_SESSION['error'] = 'Le mot de passe doit contenir au moins un chiffre.';
            header("Location: formulaireinscription.php");
            exit();
            break;
        case !preg_match("/^[a-zA-Z0-9_\-!@#$%^&*()+=[\]{};:,.<>\/?|%\\\\]+$/", $password):
            $_SESSION['error'] = 'Le mot de passe ne doit contenir que des lettres, des chiffres, des tirets et des underscores.';
            header("Location: formulaireinscription.php");
            exit();
            break;
        case $password !== $confirm_password: // Vérification des deux mots de passe
            $_SESSION['error'] = 'Les mots de passe ne correspondent pas.';
            header("Location: formulaireinscription.php");
            exit();
            break;
    }


    // Vérification de l'existence de l'email dans la base de données
    if (!empty($email)) {
        $stmt = $db->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $_SESSION['error'] = "L'adresse email est déjà utilisée.";
            header("Location: formulaireinscription.php");
            exit();
        }
    }
    // Vérification de l'existence de l'username dans la base de données
    if (!empty($username)) {
        $stmt = $db->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $_SESSION['error'] = "Le nom d'utilisateur est déjà utilisé.";
            header("Location: formulaireinscription.php");
            exit();
        }
        // Validation de l'username pour autoriser les lettres, les chiffres, les tirets, les underscores et certains caractères spéciaux
        if (!preg_match("/^[a-zA-Z0-9@_\-]+$/", $password)) {
            $_SESSION['error'] = "Le nom d'utilisateur contient des caractères non autorisés.";
            header("Location: formulaireinscription.php");
            exit();
        }
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
