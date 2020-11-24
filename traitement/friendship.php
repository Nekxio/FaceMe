<?php
    if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la pgae de login
        header("Location:index.php?action=login");
    }
        $idAmi = $_GET['id'];
        $sql="INSERT INTO lien VALUES(NULL,?,?,'attente')";
        $q = $pdo->prepare($sql);
        $q->execute(array($_POST['contenu'], date("Y-m-d H:i:s"),$_SESSION['id'], $idAmi));
        header("Location: index.php?action=profile&id=".$_SESSION['id']);
?>