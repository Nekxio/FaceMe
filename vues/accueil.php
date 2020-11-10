<?php
 if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la pgae de login
        header("Location:index.php?action=login");
    }

    // On veut affchier notre mur ou celui d'un de nos amis
    $ok = false;

    if(!isset($_GET["id"]) || $_GET["id"]==$_SESSION["id"]){ 
        $id = $_SESSION["id"];
        $ok = true; // On a le droit d afficher notre mur
        

    } else {
        $id = $_GET["id"];
        // Verifions si on est amis avec cette personne
        $sql = "SELECT * FROM lien WHERE etat='ami'
                AND ((idUtilisateur1=? AND idUtilisateur2=?) OR ((idUtilisateur1=? AND idUtilisateur2=?)))";

        // les deux ids à tester sont : $_GET["id"] et $_SESSION["id"]
        // A completer. Il faut récupérer une ligne, si il y en a pas ca veut dire que lon est pas ami avec cette personne
        $query = $pdo -> prepare($sql);
        $query -> execute(array($_GET["id"],$_SESSION["id"],$_SESSION["id"],$_GET["id"]));
        $result = $query -> fetch();
        if ($result != false){
            $ok = true;
        }
    }
    if($ok==false) {
        echo "Vous n êtes pas encore ami, vous ne pouvez voir son mur !!";       
    } else {
    // A completer
    // Requête de sélection des éléments dun mur
     // SELECT * FROM ecrit WHERE idAmi=? order by dateEcrit DESC
     // le paramètre  est le $id
     $sql = "SELECT ecrit.*, user.name FROM ecrit JOIN user ON ecrit.idAuteur=user.id WHERE idAmi=? order by dateEcrit DESC";
     $query = $pdo -> prepare($sql);
        $query -> execute(array($_SESSION["id"]));
        while($result = $query -> fetch()){
    ?>
    
    <div class="post_complet">
        <div class="post_user">
            <h1><?= $result['name'] ?></h1>
            <p><?= $result['contenu'] ?></p>
            <img src="<?= $result['contenu'] ?>" alt="image de <?= $result['name'] ?>."/>
        </div>
        <div>
            <h1>Commentaires</h1>
            <form action="index.php?action=commentaire" method="POST">
                <label><b><?= $result['name'] ?></b></label>
                <input type="text" placeholder="Ecrire une réponse..." name="answer" required>
                <input type="submit" id='submit' value='Envoyer' >
            </form>
        </div>
        <div>
            
        </div>
    </div>
    <?php      
            }
        }
?>
