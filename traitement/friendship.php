<?php
    sleep(2);
    if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la pgae de login
        header("Location:index.php?action=login");
    }
        //verifier si $get id et $session id deja present dans la table
        $sql="INSERT INTO lien VALUES(NULL,?,?,'attente')";
        $q = $pdo->prepare($sql);
        $q->execute(array($_SESSION["id"],$_GET["id"]));
        header('Location: ' . $_SERVER["HTTP_REFERER"] );
?>