<?php
    if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la pgae de login
        header("Location:index.php?action=login");
    }
    include('upload_com.php');
    if($target_file != "uploads/coms/1"){
        $sql="INSERT INTO commentaires (contenu, dateCom, idAuteur, idPost, imageCom) VALUES (?,?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($_POST['contenu'], date("Y-m-d H:i:s"),$_SESSION['id'],$_GET['idPost'], $target_file));
        header('Location: ' . $_SERVER["HTTP_REFERER"] );
    }else{
        $sql="INSERT INTO commentaires (contenu, dateCom, idAuteur, idPost) VALUES (?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($_POST['contenu'], date("Y-m-d H:i:s"),$_SESSION['id'],$_GET['idPost']));
        header('Location: ' . $_SERVER["HTTP_REFERER"].$_GET['id'] );
    }
?>