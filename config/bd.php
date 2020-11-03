<?php
    // Script login.php utilisé pour la connexion à la BD

    $host = HOST;

    $db = DB;

    $user = USER;

    $passwd = PASSWORD;


    try {
        // On essaie de créer une instance de PDO.
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $passwd, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage() . "<br />";
        die(1);
    }
?>