<?php
    sleep(2);
    if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la pgae de login
        header("Location:index.php?action=login");
    }


    $sql="SELECT * FROM lien WHERE idUtilisateur1=? AND idUtilisateur2=? AND etat='attente'";
        $q = $pdo->prepare($sql);
        $q->execute(array($_GET['id'], $_SESSION['id']));
        $result = $q -> fetch();
        if($result === false){
            echo "PAS D'INVITATION";
        }else{
            if($_GET['reponse'] == 'accepter'){
                $sql3="UPDATE lien SET etat=? WHERE idUtilisateur1=? AND idUtilisateur2=?";
                $q3 = $pdo->prepare($sql3);
                $q3->execute(array('ami', $_GET['id'], $_SESSION['id']));
            }elseif($_GET['reponse'] == 'refuser'){
                $sql3="DELETE FROM lien WHERE idUtilisateur1=? AND idUtilisateur2=?";
                $q3 = $pdo->prepare($sql3);
                $q3->execute(array($_GET['id'], $_SESSION['id']));
            }elseif($_GET['reponse'] == 'bannir'){
                $sql3="UPDATE lien SET etat=? WHERE idUtilisateur1=? AND idUtilisateur2=?";
                $q3 = $pdo->prepare($sql3);
                $q3->execute(array('banni', $_GET['id'], $_SESSION['id']));
            }
        }
        header('Location: ' . $_SERVER["HTTP_REFERER"] );
?>