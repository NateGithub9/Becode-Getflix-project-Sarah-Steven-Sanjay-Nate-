<?php
session_start();
include './configdb.php';

$upload_dir = __DIR__ . '/avatars/';

if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["avatar"])) {
    if ($_FILES["avatar"]["error"] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["avatar"]["tmp_name"];
        $name = basename($_FILES["avatar"]["name"]);
        $extension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        
        // Vérifier l'extension du fichier
        $allowed_extensions = ['png', 'jpg', 'jpeg'];
        if (!in_array($extension, $allowed_extensions)) {
            $_SESSION['messageupdateavatar'] = "Seuls les fichiers PNG et JPG sont autorisés.";
            header('Location: profil.php');
            exit();
        }

        $file_name = preg_replace("/[^a-zA-Z0-9.]/", "_", $name);
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($tmp_name, $target_file)) {
            // Stockez le nom du fichier dans la session
            $_SESSION['avatar'] = $file_name;
            
            // Mettez à jour la base de données
            $id = $_SESSION['user_id'];
            $sql = "UPDATE users SET avatar = :avatar WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':avatar', $file_name, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                $_SESSION['messageupdateavatar'] = "Votre avatar a été mis à jour avec succès.";
            } else {
                $_SESSION['messageupdateavatar'] = "Erreur lors de la mise à jour de l'avatar dans la base de données.";
            }
        } else {
            $_SESSION['messageupdateavatar'] = "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
        }
    } else {
        $_SESSION['messageupdateavatar'] = "Erreur lors du téléchargement : " . $_FILES["avatar"]["error"];
    }
} else {
    $_SESSION['messageupdateavatar'] = "Aucun fichier n'a été téléchargé.";
}

header('Location: profil.php');
exit();
?>