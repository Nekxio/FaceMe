<?php
    include('./upload.php');
    if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la pgae de login
        header("Location:index.php?action=login");
    }
        $sql="INSERT INTO ecrit (contenu, dateEcrit, idAuteur, idAmi, image) VALUES (?,?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($_POST['contenu'], date("Y-m-d H:i:s"), $_SESSION['id'], $_GET['id'], $target_file));
        header('Location: ' . $_SERVER["HTTP_REFERER"] );
?>