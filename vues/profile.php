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
    <div class="bg-profile">
        <img src="<?= $result['background'] ?>" alt="background de <?= $result['name'] ?>." />
        <img src="<?= $result['avatar'] ?>" alt="image de <?= $result['name']?>." />
        <h1 class="profile_name"><?= $result['name'] ?></h1>
    </div>
    <div>
            <div>
                <a href="#"><img src="settings.png" alt="paramètres"></a>
                <div class="biography">
                    <h1 class="title orange">Biographie</h1>
                    <p class="biography-text"><?= $result['bio'] ?></p>
                </div>
                <div class="friends">
                    <a href="#" class="title orange">Amis</a>
                    <div>
                        <?php 
                            for ($i=0; $i<9; $i++){
                            ?>
                            <img src='<?=$result['avatar']?>' alt='image de <?=$result['name']?>' />
                            <p class='friend-name'><?=$result['name']?></p>;
                            <?php
                            }
                        ?>
                    </div>
                </div>
                <div class="pictures">
                    <a href="#" class="title orange">Photos</a>
                    <div>
                        <?php
                            $sql1 = "SELECT * FROM pictures WHERE idAuteur=? DESC";
                            $query1 = $pdo -> prepare($sql1);
                            $query1 -> execute(array($_SESSION["id"]));
                            while($result1 = $query1 -> fetch()){
                                for ($j=0; $j<9; $j++){
                        ?>
                            <img src='<?=$result1['image']?>' alt='image de <?=$result1['name']?>' />
                        <?php
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div>

            </div>
    
    </div>


    <?php
        }
    }
?>