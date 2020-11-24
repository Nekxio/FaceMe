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
        $sql2 = "SELECT * FROM user WHERE id=?";
        $query2 = $pdo -> prepare($sql2);
        $query2 -> execute(array($_SESSION['id']));
        $result2 = $query2 -> fetch()
        ?>
    <div class="bg-profile">
        
        <h1 class="profile_name"><?= $result2['name'] ?></h1>
    </div>
    <a href="">Ajouter</a>
    <div>
            <div>
                <a href="#"><img src="settings.png" alt="paramètres"></a>
                <div class="biography">
                    <h1 class="title orange">Biographie</h1>
                    <p class="biography-text"><?= $result2['bio'] ?></p>
                </div>
                <div class="friends">
                    <a href="#" class="title orange">Amis</a>
                    <div>
                        <?php
                            $sql3 ="SELECT user.* FROM user INNER JOIN lien ON idUtilisateur1=user.id AND etat='ami' AND idUtilisateur2=? UNION SELECT user.* FROM user INNER JOIN lien ON idUtilisateur2=user.id AND etat='ami' AND idUtilisateur1=? LIMIT 9";
                            $query3 = $pdo->prepare($sql3);
                            $query3->execute(array($_GET['id'],$_SESSION['id']));
                            while($result3 = $query3 -> fetch()){
                            ?>
                                <img src='<?=$result3['avatar']?>' alt='image de <?=$result3['name']?>' />
                                <p class='friend-name'><?=$result3['name']?></p>;
                                <?php
                            }
                        ?>
                    </div>
                </div>
                <div class="pictures">
                    <a href="#" class="title orange">Photos</a>
                    <div>
                        <?php
                            $sql4 = "SELECT * FROM pictures WHERE idAuteur=?";
                            $query4 = $pdo -> prepare($sql4);
                            $query4 -> execute(array($_SESSION["id"]));
                            while($result4 = $query4 -> fetch()){
                                for ($j=0; $j<9; $j++){
                        ?>
                            <img src='<?=$result4['image']?>' alt='image de <?=$result2['name']?>' />
                        <?php
                                }
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
        <?php // Requête de sélection des éléments dun mur
            // SELECT * FROM ecrit WHERE idAmi=? order by dateEcrit DESC
            // le paramètre  est le $id
            $sql6 = "SELECT ecrit.*, user.name FROM ecrit JOIN user ON ecrit.idAuteur=user.id WHERE idAmi=? order by dateEcrit DESC";
            $query6 = $pdo -> prepare($sql6);
                $query6 -> execute(array($_SESSION["id"]));
                while($result6 = $query6 -> fetch()){
            ?>
            <div class="post_complet">
                <div class="post_completpadding">
                    <div>
                        <div class="post_user">
                            <img src="./src/icons/user_orange.svg" alt="icône user orange">
                            <h1><?= $result6['name'] ?></h1>
                        </div>
                        <div class="post_contenu">
                            <p><?= $result6['contenu'] ?></p>
                            <?php
                                if(isset($result6['image'])){
                            ?>
                                <img src="<?= $result6['image'] ?>" alt="image de <?= $result6['name'] ?>."/>
                            <?php
                            }
                        ?>
                        </div>
                    </div>
                    <hr class="separation_grise">
                    <div class="post_commentaires">
                        <h1>Commentaires</h1>
                        <form action='index.php?action=commentaires&idPost=<?= $result6['id']?>' method='POST' class="post_commentairesForm">
                            <label><?= $result6['name'] ?></label>
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
                            $sql7 = "SELECT commentaires.*, user.name FROM commentaires JOIN user ON commentaires.idAuteur=user.id WHERE idPost=? order by dateCom DESC";
                            $query7 = $pdo -> prepare($sql7);
                            $query7 -> execute(array($result6["id"]));
                            while($result7 = $query7 -> fetch()){
                        ?>
                            <h1><?= $result7['name'] ?></h1>
                            <p><?= $result7['contenu'] ?></p>
                            <?php } ?>
                    </div>
                </div>
            </div>
        </div>
<?php
        }
    }
?>