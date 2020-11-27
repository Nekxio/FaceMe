<?php
    if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la pgae de login
        header("Location:index.php?action=login");
    }
    
        $sql="INSERT INTO aime (idUtilisateur, idPost) VALUES (?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($_SESSION['id'], $_GET['id']));
        header('Location: ' . $_SERVER["HTTP_REFERER"] );
?>