<?php
    if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la pgae de login
        header("Location:index.php?action=login");
    }

    // On veut affchier notre mur ou celui d'un de nos amis
    $ok = false;

    if(!isset($_GET["id"]) || $_GET["id"]==$_SESSION["id"]) { 
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
        if ($result != false) {
            $ok = true;
        }
    }

    if ($ok==false) {      
        $sql1 = "SELECT * FROM lien WHERE idUtilisateur2=? AND idUtilisateur1=?";
        $query1 = $pdo -> prepare($sql1);
        $query1 -> execute(array($_GET['id'], $_SESSION['id']));
        $result1 = $query1 -> fetch();
        if($result1['etat'] == 'attente') {
            echo "<p class='container requestTime'>Demande envoyée, attente de sa réponse !</p>";
        } else {
    ?>
    <div class="container requestBtn__main">
        <a href="index.php?action=friendship&id=<?= $_GET['id'] ?>" class="requestBtn" onclick="friendship()">Ajouter</a>
    </div>
    <?php
        };
    ?>
    <div class="container">
        <p class="requestText">Vous n'êtes pas encore ami, vous ne pouvez pas voir ses photos !</p>
        <?php       
        } else {
            $sql2 = "SELECT * FROM user WHERE id=?";
            $query2 = $pdo -> prepare($sql2);
            $query2 -> execute(array($_GET['id']));
            $result2 = $query2 -> fetch()
        ?>
    </div>

    <div class="container">
        <p class="profileHeader">Photos de <?= $result2['name'] ?></p>
    </div>
    <?php
        $sql5 = "SELECT * FROM user";
        $query5 = $pdo -> prepare($sql5);
        $query5 -> execute(array($_SESSION["id"]));
        $result5 = $query5 -> fetch();
    ?>
    <?php
            if($_SESSION['id'] == $_GET['id']){
        ?>
                <form action='index.php?action=form_photo&id=<?= $id?>' method='POST' class="post_form" enctype="multipart/form-data">
                        <div class="post_commentairesFlex">
                        <h1>Poster une nouvelle photo :</h1>
                        <input type="file" name="image" id="real_input">
                        <button class="post_commentairesIcon" type="button" id="customBtn">
                            <img src="./src/icons/add.svg" alt="icône ajout fichier">
                        </button>
                        <button type='submit' class="post_commentairesIcon post_envoyerSpecial">
                            <img src="./src/icons/send.svg" alt="icône envoyer">
                        </button>
                    </div>
                </form>
        <?php
            }
        ?>
        <?php 
            // Requête de sélection des éléments dun mur
            // SELECT * FROM ecrit WHERE idAmi=? order by dateEcrit DESC
            // le paramètre  est le $id
            $sql6 = "SELECT user.name, user.avatar, pictures.* FROM user JOIN pictures ON user.id = pictures.idAuteur WHERE user.id=? order by dateImage DESC";
            $query6 = $pdo -> prepare($sql6);
            $query6 -> execute(array($_GET["id"]));
            while($result6 = $query6 -> fetch()){;
        ?>
    </section>

    <section class="container">
            <img src="<?=$result6['picture']?>" alt="photo de <?=$result6['name'] ?>" />
        <?php
            }
        }
    
  
    ?>
           
    </section>


    <section class="container">
        <div class="topArea">
            <p class="topArea__text">Vous avez bien scrollé ! Remontez au sommet !</p>
            <a class="topArea__button" onclick="scrollToTop()">
                <img src="./src/icons/uparrow.svg" alt="Icône flèche du haut">
            </a>
        </div>
    </section>
<?php

?>
