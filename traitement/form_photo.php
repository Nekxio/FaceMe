<?php
    if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la pgae de login
        header("Location:index.php?action=login");
    }   include('upload_pictures.php');
        $sql="INSERT INTO pictures (picture, dateImage, idAuteur) VALUES (?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($target_file, date("Y-m-d H:i:s"), $_SESSION['id']));
        header('Location: ' . $_SERVER["HTTP_REFERER"] );
?>