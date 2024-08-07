<?php
   // Récupérer l'URL de la base de données depuis les variables d'environnement
   $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
   $cleardb_server = $cleardb_url["DATABASE_HOST"];
   $cleardb_username = $cleardb_url["DATABASE_USER"];
   $cleardb_password = $cleardb_url["DATABASE_PASSWORD"];
   $cleardb_db = substr($cleardb_url["DATABASE_NAME"],1);

   // Connexion à la base de données
   try {
       $db = new PDO("mysql:host=$cleardb_server;dbname=$cleardb_db", $cleardb_username, $cleardb_password);
       $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   } catch(PDOException $e) {
       echo "Erreur de connexion : " . $e->getMessage();
       die();
   }