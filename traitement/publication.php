<?php
    if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la pgae de login
        header("Location:index.php?action=login");
    }   include('upload_post.php');
    if($target_file != "uploads/post/1"){
        $sql="INSERT INTO ecrit (contenu, dateEcrit, idAuteur, idAmi, image) VALUES (?,?,?,?,?); INSERT INTO pictures (picture, dateImage, idAuteur) VALUES (?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($_POST['contenu'], date("Y-m-d H:i:s"), $_SESSION['id'], $_GET['id'], $target_file, $target_file, date("Y-m-d H:i:s"), $_SESSION['id']));
        header('Location: ' . $_SERVER["HTTP_REFERER"] );
    }else{
        $sql="INSERT INTO ecrit (contenu, dateEcrit, idAuteur, idAmi) VALUES (?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($_POST['contenu'], date("Y-m-d H:i:s"), $_SESSION['id'], $_GET['id']));
        header('Location: ' . $_SERVER["HTTP_REFERER"] );
    }
?>