<?php
    sleep(2);
    if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la pgae de login
        header("Location:index.php?action=login");
    }

        $sql1="SELECT * FROM lien WHERE idUtilisateur1=? AND idUtilisateur2=?";
        $q1 = $pdo->prepare($sql1);
        $q1->execute(array($_GET['id'], $_SESSION['id']));
        $result1 = $q1 -> fetch();
        if($result['etat']=="banni"){
            $ban = $result['etat'];
        }
        
        //verifier si l'utilisateur n'a pas été banni
        if(!isset($ban)){
            //verifier si $get id et $session id deja present dans la table
            $sql="INSERT INTO lien VALUES(NULL,?,?,'attente')";
            $q = $pdo->prepare($sql);
            $q->execute(array($_SESSION["id"],$_GET["id"]));
            header('Location: ' . $_SERVER["HTTP_REFERER"] );
        }
        
        
?>