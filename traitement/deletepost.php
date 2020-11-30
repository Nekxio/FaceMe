<?php
    if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la pgae de login
        header("Location:index.php?action=login");
    }
        $sql="DELETE FROM ecrit WHERE id=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($_GET['id']));
        $sql2 ="DELETE FROM aime WHERE idPost=?";
        $q2 = $pdo->prepare($sql2);
        $q2->execute(array($_GET['id']));
        $sql3 ="DELETE FROM commentaires WHERE idPost=?";
        $q3 = $pdo->prepare($sql3);
        $q3->execute(array($_GET['id']));
        header('Location: ' . $_SERVER["HTTP_REFERER"]."#".$_GET['id'] );
        exit;
?>