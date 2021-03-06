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
            $sql1 = "SELECT user.id, user.avatar, user.mdp, user.background, user.name FROM user WHERE id=?";
            $query1 = $pdo -> prepare($sql1);
            $query1 -> execute(array($_GET['id']));
            $result1 = $query1 -> fetch()
        ?>
    <div class="container profileImg_background" style="background-image : url(<?= $result1['background'] ?>)">
        <div class="profileHeader__main">
            <img class="profileImg_avatar" src="<?=$result1['avatar']?>" alt="Photo de profil de <?= $result1['name']?>"/>
            <h1 class="profileText_name"><?= $result1['name'] ?></h1>
        </div>
    </div>
    
    <?php       
        $sql1 = "SELECT * FROM lien WHERE idUtilisateur2=? AND idUtilisateur1=?";
        $query1 = $pdo -> prepare($sql1);
        $query1 -> execute(array($_GET['id'], $_SESSION['id']));
        $result1 = $query1 -> fetch();
        if($result1['etat'] == 'attente') {
            echo "<p class='container requestTime'>Demande envoyée, attente de sa réponse !</p>";
        }elseif ($result1['etat'] == 'banni'){
            echo "<p>Vous ne pouvez pas ajouter cette personne</p>";
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
            $sql2 = "SELECT user.id, user.avatar, user.background, user.name, user.bio FROM user WHERE id=?";
            $query2 = $pdo -> prepare($sql2);
            $query2 -> execute(array($_GET['id']));
            $result2 = $query2 -> fetch()
        ?>
    </div>
    <div class="container profileImg_background" style="background-image : url(<?= $result2['background'] ?>)">
        <div class="profileHeader__main">
            <img class="profileImg_avatar" src="<?=$result2['avatar']?>" alt="Photo de profil de <?= $result2['name']?>"/>
            <h1 class="profileText_name"><?= $result2['name'] ?></h1>
        </div>
    </div>
    <div class="container profileAside__main">
        <div class="profileAside__mainPadding">
            <div class="biography">
                <h1 class="profileAside__Title">Biographie</h1>
                <p class="profileAside__bioText"><?= $result2['bio'] ?></p>
                <hr class="profileAside__bioSeparation">
            </div>
            <div class="profileAside__Title">
                <a href="index.php?action=photos&id=<?=$_GET["id"]?>">Photos</a>
                    <div class="profileAside__photosSettings">
                        <?php
                            $sql6 = "SELECT user.id, user.name, pictures.* FROM user JOIN pictures ON user.id = pictures.idAuteur WHERE user.id=? order by dateImage DESC LIMIT 5";
                            $query6 = $pdo -> prepare($sql6);
                            $query6 -> execute(array($_GET["id"]));
                            while($result6 = $query6 -> fetch()){;
                        ?>
                            <img src="<?=$result6['picture']?>" alt="photo de <?=$result6['name'] ?>"/>
                        <?php
                            }
                        
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <div>
    <?php
        $sql5 = "SELECT user.id, user.avatar, user.background, user.name, user.bio FROM user";
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
                        <input type="file" name="image" id="real_inputPost" hidden="hidden">
                        <button class="post_commentairesIcon" type="button" onclick="filePost()">
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
            $sql6 = "SELECT *, ecrit.id AS idPost ,user.name  FROM ecrit JOIN user ON ecrit.idAuteur = user.id WHERE idAmi=? order by dateEcrit DESC";
            $query6 = $pdo -> prepare($sql6);
            $query6 -> execute(array($_GET["id"]));
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
                            <p class="post_userIdName"><?= $result6['name'] ?> a publié :</p>
                        </div>
                        <?php
                        if($_SESSION['id'] == $_GET['id']){
                        ?>
                       
                        <div class="post_userBin">
                            <a href="index.php?action=deletepost&id=<?= $result6['idPost']?>">
                                <img src="./src/icons/trash.svg" onmouseover="newBin()" onmouseout="oldBin()" alt="icône poubelle" id="post_userBin">
                            </a>
                        </div>
                        <?php
                            }
                        ?>
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
                    <form action='index.php?action=commentaires&idPost=<?= $result6['idPost']?>' method='POST' class="post_commentairesForm" enctype="multipart/form-data">
                        <div class="post_commentairesAvatarFlex">
                            <?php
                                    $sql20 = "SELECT user.avatar FROM user WHERE id=?" ;
                                    $query20 = $pdo -> prepare($sql20);
                                    $query20 -> execute(array($_SESSION['id']));
                                    $result20 = $query20 -> fetch();
                                ?>
                            <img class="post_commentairesAvatar" src="<?= $result20['avatar'] ?>" />
                            <label class="post_commentairesName"><?= $_SESSION['name'] ?></label>
                        </div>
                        <input type='text' placeholder='Écrire un commentaire' name='contenu' class="post_commentairesInput" id="input_commentFocus">
                        <hr class="separation_orange">
                        <div class="post_commentairesFlex">
                            <input type="file" name="imageCom" id="real_inputCom" hidden="hidden">
                            <button class="post_commentairesIcon" type="button" onclick="fileCom()">
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
                        $query7 -> execute(array($result6["idPost"]));
                        while($result7 = $query7 -> fetch()){
                    ?>
                        <div class="vueCommentaires">
                            <div class="vueCommentaires__flex">
                                <div class="vueCommentaires__flexText">
                                    <p>Le <?=$result7['dateCom']?></p>
                                    <p class="bold"><?= $result7['name'] ?></p><p> a commenté :</p>
                                </div>
                                <?php
                                    if($_SESSION['id'] == $_GET['id']){
                                ?>
                                    <div class="post_userBin">
                                        <a href="index.php?action=deletecom&id=<?= $result7['id']?>">
                                            <img src="./src/icons/trash.svg" onmouseover="newBin()" onmouseout="oldBin()" alt="icône poubelle" id="post_userBin">
                                        </a>
                                    </div>
                                <?php
                                }
                                ?>
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
