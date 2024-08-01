<?php 
// Définition des constantes pour la connexion à la base de données
// dbhost : nom d'hôte du serveur MySQL
// dbuser : nom d'utilisateur à utiliser pour la connexion à la base de données
// dbpass : mot de passe à utiliser pour la connexion à la base de données
// dbname : nom de la base de données à utiliser

const dbhost = "db"; // nom d'hôte du serveur MySQL
const dbuser = "test"; // nom d'utilisateur à utiliser pour la connexion à la base de données
const dbpass = "pass"; // mot de passe à utiliser pour la connexion à la base de données
const dbname = "GetflixDB"; // nom de la base de données à utiliser

// Création de la chaîne de connexion à la base de données
$dsn = "mysql:host=" . dbhost . ";dbname=" . dbname . ";charset=utf8";

// Tentative de connexion à la base de données
try {
    $db = new PDO($dsn, dbuser, dbpass);

} 
catch (PDOException $exception) {
    // Si une erreur se produit lors de la connexion à la base de données, l'erreur est affichée et le programme s'arrête
    echo $exception->getMessage();
    die;
}

