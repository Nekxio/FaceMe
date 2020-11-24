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
    ?>
       <h1>Vous n'êtes pas encore ami, vous ne pouvez pas voir le mur !</h1>
    <?php   
    } else {
        $sql2 = "SELECT * FROM user";
        $query2 = $pdo -> prepare($sql2);
        $query2 -> execute(array($_SESSION["id"]));
        $result2 = $query2 -> fetch();
        ?>        

   <div class="container">
       <div class="publication">
        <h1 class="publication__title">Dîtes à vos amis comment se passe votre journée</h1>
            <form action='index.php?action=publication&id=<?= $id?>' method='POST' class="post_form">
                <input type='text' placeholder='Écrire une publication' name='contenu' required class="publication_input">
                <hr class="separation_orange">
                <div class="post_commentairesFlex">
                    <button type='file' class="post_commentairesIcon">
                        <img src="./src/icons/add.svg" alt="icône ajout fichier">
                    </button>
                    <button type='submit' class="post_commentairesIcon">
                        <img src="./src/icons/send.svg" alt="icône envoyer">
                    </button>
                </div>  
            </form>
       </div>
    </div>
   <?php // Requête de sélection des éléments dun mur
     // SELECT * FROM ecrit WHERE idAmi=? order by dateEcrit DESC
     // le paramètre  est le $id
     $sql = "SELECT ecrit.*, user.name FROM ecrit JOIN user ON ecrit.idAuteur=user.id WHERE idAmi=? order by dateEcrit DESC";
     $query = $pdo -> prepare($sql);
        $query -> execute(array($_SESSION["id"]));
        while($result = $query -> fetch()){
    ?>

    <section class="container">
    <div class="post_complet">
        <div class="post_completpadding">
        <a href="index.php?action=deletepost&id=<?= $result['id']?>">Delete</a>
            <div>
                <div class="post_user">
                    <img src="./src/icons/user_orange.svg" alt="icône user orange">
                    <h1><?= $result['name'] ?></h1>
                </div>
                <div class="post_contenu">
                    <p><?= $result['contenu'] ?></p>
                    <?php
                        if(isset($result['image'])){
                    ?>
                        <img src="<?= $result['image'] ?>" alt="image de <?= $result['name'] ?>."/>
                    <?php
                    }
                ?>
                </div>
            </div>
            <hr class="separation_grise">
            <div class="post_commentaires">
                <h1>Commentaires</h1>
                <form action='index.php?action=commentaires&idPost=<?= $result['id']?>' method='POST' class="post_commentairesForm">
                    <label><?= $result['name'] ?></label>
                    <input type='text' placeholder='Écrire un commentaire' name='contenu' required class="post_commentairesInput">
                    <hr class="separation_orange">
                    <div class="post_commentairesFlex">
                        <button type='file' class="post_commentairesIcon">
                            <img src="./src/icons/add.svg" alt="icône ajout fichier">
                        </button>
                        <button type='submit' class="post_commentairesIcon">
                            <img src="./src/icons/send.svg" alt="icône envoyer">
                        </button>
                    </div>  
                </form>
            </div>
            <div>
                <?php
                    $sql1 = "SELECT commentaires.*, user.name FROM commentaires JOIN user ON commentaires.idAuteur=user.id WHERE idPost=? order by dateCom DESC";
                    $query1 = $pdo -> prepare($sql1);
                    $query1 -> execute(array($result["id"]));
                    while($result1 = $query1 -> fetch()){
                ?>
                <div class="vueCommentaires">
                    <a href="index.php?action=deletecom&idPost=<?= $result['id']?>">Delete</a>
                    <div class="vueCommentaires__flex">
                        <h1 class="vueCommentaires__title"><?= $result1['name'] ?></h1><p class="vueCommentaires__text"> a écrit :</p>
                    </div>
                    <p class="vueCommentaires__content"><?= $result1['contenu'] ?></p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    </section>
    
<?php
        }
?><section class="container">
    <div class="topArea">
        <p class="topArea__text">Vous avez bien scrollé ! Remontez au sommet !</p>
        <a class="topArea__button" onclick="scrollToTop()">
            <img src="./icons/uparrow.svg" alt="Icône flèche du haut">
        </a>
    </div>
</section>
<?php
    }
?>