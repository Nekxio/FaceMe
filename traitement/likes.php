<?php
    if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la pgae de login
        header("Location:index.php?action=login");
    }
        $sql="SELECT * FROM aime WHERE idUtilisateur=? AND idPost=?";
        $q = $pdo->prepare($sql);
        $q->execute(array($_SESSION['id'], $_GET['id']));
        $result = $q -> fetch();
        if($result === false){
            $sql2="INSERT INTO aime (idUtilisateur, idPost) VALUES (?,?)";
            $q2 = $pdo->prepare($sql2);
            $q2->execute(array($_SESSION['id'], $_GET['id']));
        }else{
            $sql3="DELETE FROM aime WHERE idUtilisateur=? AND idPost=?";
            $q3 = $pdo->prepare($sql3);
            $q3->execute(array($_SESSION['id'], $_GET['id']));
        }
        header('Location: ' . $_SERVER["HTTP_REFERER"]."#".$_GET['id'] );
?>