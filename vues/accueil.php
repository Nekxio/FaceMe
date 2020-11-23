    <div id="headerFond">
        <div class="container headerFlex">
            <div id="headerLogo">
                <img src="./icons/logo.svg" alt="Logo FaceMe">
            </div>
            <div id="headerSearch">
                <img src="./icons/loupe.svg" alt="Icone loupe">
                <input type="text" placeholder="Rechercher" id="headerSearch__input">
            </div>
            <div id="headerUser">
                <button id="headerUser__button" onclick="userHover()">
                    <img src="./icons/user_white.svg" alt="Icone utilisateur">
                </button>
                <div id="headerHover__menu">
                    <ul>
                        <li><a href="">Mon Profil</a></li>
                        <li><a href="">Mes Paramètres</a></li>
                        <li><a href="">Se déconnecter</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

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
                        <img src="./icons/add.svg" alt="icône ajout fichier">
                    </button>
                    <button type='submit' class="post_commentairesIcon">
                        <img src="./icons/send.svg" alt="icône envoyer">
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
            <div>
                <div class="post_user">
                    <img src="./icons/user_orange.svg" alt="icône user orange">
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
                            <img src="./icons/add.svg" alt="icône ajout fichier">
                        </button>
                        <button type='submit' class="post_commentairesIcon">
                            <img src="./icons/send.svg" alt="icône envoyer">
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
                    <h1><?= $result1['name'] ?></h1>
                    <p><?= $result1['contenu'] ?></p>
                    <?php } ?>
            </div>
        </div>
    </div>

    </section>
<?php
        }
    }
?>