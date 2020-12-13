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
    ?>
    <?php       
            $sql1 = "SELECT * FROM user WHERE id=?";
            $query1 = $pdo -> prepare($sql1);
            $query1 -> execute(array($_GET['id']));
            $result1 = $query1 -> fetch()
        ?>
    <div style="background-image : url(<?= $result1['background'] ?>)">
        
        <img src="<?=$result1['avatar']?>" alt="Photo de profil de <?= $result1['name']?>"/>
        <h1 class="profile_name"><?= $result1['name'] ?></h1>
    </div>
    
    <?php       
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
        <p class="requestText">Vous n'êtes pas encore ami, vous ne pouvez pas voir son profil !</p>
        <?php       
        } else {
            $sql2 = "SELECT * FROM user WHERE id=?";
            $query2 = $pdo -> prepare($sql2);
            $query2 -> execute(array($_GET['id']));
            $result2 = $query2 -> fetch()
        ?>
    </div>
    <div class="container" style="background-image : url(<?= $result2['background'] ?>)">
        <img src="<?=$result2['avatar']?>" alt="Photo de profil de <?= $result2['name']?>"/>
        <h1 class="profileHeader"><?= $result2['name'] ?></h1>
    </div>
    <div class="profileAside">
        <div class="biography">
            <h1 class="profileAside__bioTitle">Biographie</h1>
            <p class="profileAside__bioText"><?= $result2['bio'] ?></p>
            <hr class="profileAside__bioSeparation">
        </div>
        <div class="profileAside__bioFriends">
            <a href="index.php?action=amis&id=<?=$_GET["id"]?>">Amis</a>
            <div>
                <?php
                    //$sql3 ="SELECT user.*, lien.idUtilisateur1 AS user, lien.idUtilisateur2 AS me, lien.etat AS etat FROM user INNER JOIN lien ON idUtilisateur1=user.id  AND idUtilisateur2=? UNION SELECT user.* FROM user INNER JOIN lien ON idUtilisateur2=user.id AND etat='ami' AND idUtilisateur1=? LIMIT 9";
                    //$query3 = $pdo->prepare($sql3);
                    //$query3->execute(array($_SESSION['id']));
                    //while($result3 = $query3 -> fetch()){
                ?>
                <!--<img src='<?=$result3['avatar']?>' alt='image de <?=$result3['name']?>' />
                <p class='friend-name'><?=$result3['name']?></p>-->
                <?php
                    //}
                ?>
            </div>
        </div>
        <div class="profileAside__bioPhotos">
            <a href="index.php?action=photos&id=<?=$_GET["id"]?>">Photos</a>
                <div>
                    <?php
                        $sql6 = "SELECT user.id, user.name, pictures.* FROM user JOIN pictures ON user.id = pictures.idAuteur WHERE user.id=? order by dateImage DESC";
                        $query6 = $pdo -> prepare($sql6);
                        $query6 -> execute(array($_GET["id"]));
                        while($result6 = $query6 -> fetch()){;
                    ?>
                        <img src="<?=$result6['picture']?>" alt="photo de <?=$result6['name'] ?>" />
                    <?php
                        }
                    
                    ?>
                </div>
            </div>
        </div>
    <div>
    <?php
        $sql5 = "SELECT * FROM user";
        $query5 = $pdo -> prepare($sql5);
        $query5 -> execute(array($_SESSION["id"]));
        $result5 = $query5 -> fetch();
    ?>
    
    <section class="container">
        <div class="publication">
            <h1 class="publication__title">Dîtes à vos amis comment se passe votre journée</h1>
                <form action='index.php?action=publication&id=<?= $id?>' method='POST' class="post_form" enctype="multipart/form-data">
                    <input type='text' placeholder='Écrire une publication' name='contenu' class="publication_input">
                    <hr class="separation_orange">
                        <div class="post_commentairesFlex">
                        <input type="file" name="image" id="real_input" hidden="hidden">
                        <button class="post_commentairesIcon" type="button" id="customBtn">
                            <img src="./src/icons/add.svg" alt="icône ajout fichier">
                        </button>
                        <button type='submit' class="post_commentairesIcon post_envoyerSpecial">
                            <img src="./src/icons/send.svg" alt="icône envoyer">
                        </button>
                    </div>
                </form>
        </div>
        <?php 
            // Requête de sélection des éléments dun mur
            // SELECT * FROM ecrit WHERE idAmi=? order by dateEcrit DESC
            // le paramètre  est le $id
            $sql6 = "SELECT *, ecrit.id AS idPost from ecrit join user on idAuteur=user.id where idAuteur in ( SELECT user.id FROM user INNER JOIN lien ON idUtilisateur1=user.id AND etat='ami' AND idUtilisateur2=? UNION SELECT user.id FROM user INNER JOIN lien ON idUtilisateur2=user.id AND etat='ami' AND idUtilisateur1=? UNION SELECT user.id FROM user WHERE user.id=?) ORDER by ecrit.id DESC";
            $query6 = $pdo -> prepare($sql6);
            $query6 -> execute(array($_GET["id"], $_GET['id'], $_SESSION['id']));
            while($result6 = $query6 -> fetch()){
        ?>
    </section>

    <section class="container">
        <div class="post_complet">
            <div class="post_completpadding">
                <div>
                    <div class="post_user">
                        <div class="post_userId">
                            <img src="<?=$result6['avatar']?>" alt="icône user orange">
                            <h1><?= $result6['name'] ?> a publié :</h1>
                        </div>
                        <div class="post_userBin">
                            <a href="index.php?action=deletepost&id=<?= $result6['idPost']?>">
                                <img src="./src/icons/trash.svg" onmouseover="newBin()" onmouseout="oldBin()" alt="icône poubelle" id="post_userBin">
                            </a>
                        </div>
                    </div>
                    <div class="post_contenu">
                        <div class="post_contenuHour">
                            <p class="post_contenuText">Le <?=$result6['dateEcrit']?></p>
                        </div>
                        <div class="post_contenuText">
                            <p><?= $result6['contenu'] ?></p>
                        </div>
                        <?php
                            if(isset($result6['image'])){
                        ?>  
                        <div class="post_contenuImg">
                            <img src="<?= $result6['image'] ?>" alt="image de <?= $result6['name'] ?>."/>
                        </div>
                        <?php
                        }
                    ?>
                        <hr class="post_separation">
                        <div class="postComment">
                            <div class="post_likes"> 
                                <a href="index.php?action=likes&id=<?= $result6['idPost']?>">
                                    <img src="./src/icons/like.svg" alt="icône coeur" class="post_likesIcons">
                                </a>   
                                <?php
                                    $sql8 = "SELECT idPost, count(*) as likes FROM aime WHERE idPost=?" ;
                                    $query8 = $pdo -> prepare($sql8);
                                    $query8 -> execute(array($result6['idPost']));
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
                    <form action='index.php?action=commentaires&idPost=<?= $result6['id']?>' method='POST' class="post_commentairesForm" enctype="multipart/form-data">
                        <img src="<?= $result6['avatar'] ?>" />
                        <label><?= $result6['name'] ?></label>
                        <input type='text' placeholder='Écrire un commentaire' name='contenu' class="post_commentairesInput" id="input_commentFocus">
                        <hr class="separation_orange">
                        <div class="post_commentairesFlex">
                            <input type="file" name="imageCom" id="real_input" hidden="hidden">
                            <button class="post_commentairesIcon" type="button" id="customBtn">
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
                        $sql7 = "SELECT commentaires.*, user.name, user.avatar FROM user JOIN commentaires ON user.id = commentaires.idAuteur WHERE idPost=? order by dateCom DESC";
                        $query7 = $pdo -> prepare($sql7);
                        $query7 -> execute(array($result6["id"]));
                        while($result7 = $query7 -> fetch()){
                    ?>
                        <div class="vueCommentaires">
                            <div class="vueCommentaires__flex">
                                <div class="vueCommentaires__flexText">
                                    <p>Le <?=$result7['dateCom']?></p>
                                    <span><img src="<?= $result7['avatar'] ?>" /> <p><?= $result7['name'] ?></p><p> a commenté :</p></span>
                                </div>
                                <div class="post_userBin">
                                    <a href="index.php?action=deletecom&id=<?= $result7['id']?>">
                                        <img src="./src/icons/trash.svg" onmouseover="newBin()" onmouseout="oldBin()" alt="icône poubelle" id="post_userBin">
                                    </a>
                                </div>
                            </div>
                            <p class="vueCommentaires__content"><?= $result7['contenu'] ?></p>
                            <?php
                                    if(isset($result7['imageCom'])){
                                ?>
                                <div class="vueCommentaires__contentImg">
                                    <img src="<?= $result7['imageCom'] ?>" alt="image de <?= $result7['name'] ?>." width='870px'/>
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
