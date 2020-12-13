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
            <form action='index.php?action=publication&id=<?= $id?>' method='POST' class="post_form" enctype="multipart/form-data">
                <input type='text' placeholder='Écrire une publication' name='contenu' class="publication_input">
                <hr class="separation_orange">
                <div class="post_commentairesFlex">
                    <input type="file" name="image" id="real_inputPost" hidden="hidden">
                    <button class="post_commentairesIcon" type="button" id="custom_btnPost">
                        <img src="./src/icons/add.svg" alt="icône ajout fichier">
                    </button>
                    <button type='submit' class="post_commentairesIcon post_envoyerSpecial">
                        <img src="./src/icons/send.svg" alt="icône envoyer">
                    </button>
                </div>
            </form>
       </div>
    </div>
   <?php // Requête de sélection des éléments dun mur
     // SELECT * FROM ecrit WHERE idAmi=? order by dateEcrit DESC
     // le paramètre  est le $id
    $sql3 = "SELECT *, ecrit.id AS idPost from ecrit join user on idAuteur=user.id where idAuteur in ( SELECT user.id FROM user INNER JOIN lien ON idUtilisateur1=user.id AND etat='ami' AND idUtilisateur2=? UNION SELECT user.id FROM user INNER JOIN lien ON idUtilisateur2=user.id AND etat='ami' AND idUtilisateur1=? UNION SELECT user.id FROM user WHERE user.id=?) ORDER by ecrit.id DESC";
    $query3 = $pdo -> prepare($sql3);
    $query3 -> execute(array($_SESSION["id"], $_SESSION['id'], $_SESSION['id']));
    while($result3 = $query3 -> fetch()){
    ?>

    <section class="container">
    <div class="post_complet" id="<?= $result3['idPost'] ?>">
        <div class="post_completpadding">
            <div>
                <div class="post_user">
                    <div class="post_userId">
                        <img src="<?=$result3['avatar']?>" alt="icône user orange">
                        <h1><a href="index.php?action=profile&id=<?=$result3['id']?>" ><?= $result3['name'] ?></a> a publié :</h1>
                    </div>
                    <div class="post_userBin">
                        <a href="index.php?action=deletepost&id=<?= $result3['id']?>">
                            <img src="./src/icons/trash.svg" onmouseover="newBin()" onmouseout="oldBin()" alt="icône poubelle" id="post_userBin">
                        </a>
                    </div>
                </div>
                <div class="post_contenu">
                    <div class="post_contenuHour">
                        <p class="post_contenuText">Le <?=$result3['dateEcrit']?></p>
                    </div>
                    <div class="post_contenuText">
                        <p><?= $result3['contenu'] ?></p>
                    </div>
                    <?php
                        if(isset($result3['image'])){
                    ?>  
                    <div class="post_contenuImg">
                        <img src="<?= $result3['image'] ?>" alt="image de <?= $result3['name'] ?>."/>
                    </div>
                    <?php
                    }
                ?>
                    <hr class="post_separation">
                    <div class="postComment">
                        <div class="post_likes"> 
                            <a href="index.php?action=likes&id=<?= $result3['idPost']?>">
                                <img src="./src/icons/like.svg" alt="icône coeur" class="post_likesIcons">
                            </a>   
                            <?php
                                $sql8 = "SELECT idPost, count(*) as likes FROM aime WHERE idPost=?" ;
                                $query8 = $pdo -> prepare($sql8);
                                $query8 -> execute(array($result3['idPost']));
                                $result8 = $query8 -> fetch();
                            ?>
                            <p class="likes_count"><?=$result8['likes']?></p>
                        </div>
                        <button id="commentFocus" class="post_comment" onclick="commentFocus();">
                            <img src="./src/icons/message.svg" alt="icône commentaires">
                        </button>
                    </div>
                </div>
                
            </div>
            <hr class="separation_grise">
            <div class="post_commentaires">
                <h1>Commentaires</h1>
                <form action='index.php?action=commentaires&idPost=<?= $result3['id']?>' method='POST' class="post_commentairesForm" enctype="multipart/form-data">
                    <div class="post_commentairesAvatarFlex">
                        <img class="post_commentairesAvatar" src="<?= $result3['avatar'] ?>" />
                        <label class="post_commentairesName"><?= $result3['name'] ?></label>
                    </div>
                    <input type='text' placeholder='Écrire un commentaire' name='contenu' class="post_commentairesInput" id="input_commentFocus">
                    <hr class="separation_orange">
                    <div class="post_commentairesFlex">
                        <input type="file" name="imageCom" id="real_inputCom" hidden="hidden">
                        <button class="post_commentairesIcon" type="button" id="custom_btnCom">
                            <img src="./src/icons/add.svg" alt="icône ajout fichier">
                        </button>
                        <button type='submit' class="post_commentairesIcon post_envoyerSpecial">
                            <img src="./src/icons/send.svg" alt="icône envoyer">
                        </button>
                    </div>
                </form>
            </div>
            <div>
                <?php
                    $sql1 = "SELECT commentaires.*, user.name, user.avatar FROM user JOIN commentaires ON user.id = commentaires.idAuteur WHERE idPost=? order by dateCom DESC";
                    $query1 = $pdo -> prepare($sql1);
                    $query1 -> execute(array($result3["id"]));
                    while($result1 = $query1 -> fetch()){
                ?>
                    <div class="vueCommentaires">
                        <div class="vueCommentaires__flex">
                            <div class="vueCommentaires__flexText">
                                <p>Le <?=$result1['dateCom']?></p>
                                <p><?= $result1['name'] ?></p><p> a commenté :</p>
                            </div>
                            <div class="post_userBin">
                                <a href="index.php?action=deletecom&id=<?= $result1['id']?>">
                                    <img src="./src/icons/trash.svg" onmouseover="newBin()" onmouseout="oldBin()" alt="icône poubelle" id="post_userBin">
                                </a>
                            </div>
                        </div>
                        <p class="vueCommentaires__content"><?= $result1['contenu'] ?></p>
                        <?php
                                if(isset($result1['imageCom'])){
                            ?>
                            <div class="vueCommentaires__contentImg">
                                <img src="<?= $result1['imageCom'] ?>" alt="image de <?= $result1['name'] ?>."/>
                            </div>
                                <?php
                                    }
                                ?>
                    </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
    </section>
    
<?php
        }
?>

<section class="container">
    <div class="topArea">
        <p class="topArea__text">Vous avez bien scrollé ! Remontez au sommet !</p>
        <a class="topArea__button" onclick="scrollToTop()">
            <img src="./src/icons/uparrow.svg" alt="Icône flèche du haut">
        </a>
    </div>
</section>
<?php
    }
?>