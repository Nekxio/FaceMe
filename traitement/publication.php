<?php
    if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la pgae de login
        header("Location:index.php?action=login");
    }
        $sql="INSERT INTO ecrit (contenu, dateEcrit, idAuteur, idAmi) VALUES (?,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($_POST['contenu'], date("Y-m-d H:i:s"), $_SESSION['id'], $_GET['id']));
        header("Location: index.php?action=accueil");
?>