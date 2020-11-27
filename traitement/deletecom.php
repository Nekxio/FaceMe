<?php
    if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la pgae de login
        header("Location:index.php?action=login");
    }
        $sql="DELETE FROM commentaires WHERE commentaires.id=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($_GET['id']));
        header('Location: ' . $_SERVER["HTTP_REFERER"] );
        exit;
?>