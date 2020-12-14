<?php

include("config/config.php");
include("config/bd.php");
include("divers/balises.php");
include("config/actions.php");
session_start();
ob_start();

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0,viewport-fit=cover" />
        <meta name="theme-color" content="#FA9C1D" />
        <link href="./src/icons/logo_faceme.png" rel="icon" type="image/x-icon"/>
        <title>FaceMe | Le réseau social MMI</title>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
        <style>
            <?php
                include('./css/style.css');
                include('./css/normalize.css');
            ?>
        </style>
    </head>

    <body>
        <?php
            if (isset($_SESSION['info'])) {
                echo "<div>
                    <strong>Information : </strong> " . $_SESSION['info'] . "</div>";
                unset($_SESSION['info']);
            }
        ?>
            <?php
                if (isset($_SESSION['id'])) {
            ?>

            <div class="headerFond">
                <div class="container headerFlex">
                    <div class="headerLogo">
                        <a href="index.php?action=accueil">
                            <img src="./src/icons/logo.svg" alt="Logo FaceMe">
                        </a>
                    </div>
                    <div class="headerSearch">
                        <img src="./src/icons/loupe.svg" alt="Icone loupe">
                        <div class="search_main">
                            <input type="text" placeholder="Rechercher" name="recherche" id="headerSearch__input">
                            <ul id="results">
                            </ul>
                        </div>
                    </div>
                    <div class="headerButton">
                        <div class="headerUser">
                            <button class="headerUser__button" onclick="userHover()">
                            <?php
                                        $sql1 = "SELECT user.avatar FROM user WHERE id=?";
                                        $query1 = $pdo -> prepare($sql1);
                                        $query1 -> execute(array($_SESSION["id"]));
                                        $result1 = $query1 -> fetch();
                            ?>
                                <img src="<?=$result1['avatar']?>" alt="Icone utilisateur">
                            </button>
                            <div id="headerHover__menu">
                                <p id="headerHover__menuName"><?= $_SESSION['name']?></p>
                                <hr id="headerHover__menuSeparation">
                                <p class="headerHover__menuLink"><a href="index.php?action=profile&id=<?= $_SESSION['id']?>">Mon Profil</a></p> 
                                <p class="headerHover__menuLink"><a href="index.php?action=settings">Mes Paramètres</a></p>
                                <p class="headerHover__menuLink"><a href="index.php?action=deconnexion" onclick="deconnexion()">Se déconnecter</a></p>
                            </div>
                        </div>
                        <div class="headerNotif">
                                <?php
                                    $sql8 = "SELECT count(*) AS invits FROM lien WHERE idUtilisateur2=? AND etat='attente'" ;
                                    $query8 = $pdo -> prepare($sql8);
                                    $query8 -> execute(array($_SESSION['id']));
                                    $result8 = $query8 -> fetch();
                                ?>
                            <button class="headerNotif__button" onclick="notifHover()">
                                <img src="./src/icons/bell.svg" alt="Icone cloche">
                            </button>
                            <div id="headerHover__notif">
                                <ul id="headerHover__notifMain">
                                    <p id="headerHover__notifTitle">Notifications</p>
                                    <hr id="headerHover__notifSeparation">
                                    <?php
                                        $sql2 = "SELECT lien.*, user1.id AS id, user1.name AS name, user2.id FROM lien JOIN user AS user2 ON lien.idUtilisateur2=user2.id INNER JOIN user AS user1 ON lien.idUtilisateur1=user1.id WHERE lien.idUtilisateur2=? AND lien.etat='attente'";
                                        $query2 = $pdo -> prepare($sql2);
                                        $query2 -> execute(array($_SESSION["id"]));
                                        $result2 = $query2 -> fetch();
                                            if(!empty($result2)){
                                    ?>
                                    <span><?=$result2['name']?></span>
                                        <a href="index.php?action=reponse&id=<?=$result2['idUtilisateur1']?>&reponse=accepter" id="headerHover__notifAccepter">Accepter</a>
                                        <a href="index.php?action=reponse&id=<?=$result2['idUtilisateur1']?>&reponse=refuser" id="headerHover__notifAccepter">Refuser</a>
                                        <a href="index.php?action=reponse&id=<?=$result2['idUtilisateur1']?>&reponse=bannir" id="headerHover__notifAccepter">Bannir</a>
                                    <?php
                                        } else {
                                            echo "<p id='headerHover__notifRien'>Aucune invitation pour le moment</p>";
                                        };
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <p class="headerNotif__buttonText">Vous avez <?= $result8['invits'] ?> notification(s)</p>
                    </div>
                </div>
            </div>
            
                <?php
                } else {
                   ?>
                    <section class='container' id='page_connexion'>
                        <div id='page__title'>
                            <p>FaceMe</p>
                        </div>
                        <div id='formCo__fond'>
                            <p id='signIn__title'>Se connecter</p>
                            <div id='signIn__fond'>
                                <form action='index.php?action=connexion' method='POST' id='signIn__main'>
                                    <input type='text' placeholder='Adresse e-mail' class='signIn__input' name='email' required>
                                    <input type='password' placeholder='Mot de Passe' class='signIn__input' name='PASSWORD' required>
                                    <input type='submit' value='Je me connecte' class='form__submit' id='submit'>
                                </form>
                                <div id='form__separation'></div>
                                <p id='signUp__title'>On ne se connait pas encore ?</p>
                                <a href='index.php?action=create_account' class='form__submit' id='signIn__submit' onclick='connexion()'>Créer un compte</a>
                            </div>
                        </div>
                    <?php
                }
            ?>

            <?php
                if (isset($_GET["action"])) {
                $action = $_GET["action"];
                    // Est ce que cette action existe dans la liste des actions
                if (array_key_exists($action, $listeDesActions) == false) {
                    include("vues/404.php"); // NON : page 404
                } else {
                    include($listeDesActions[$action]); // Oui, on la charge
                }
            }

                ob_end_flush();
            ?>

        <script src="js/script.js"></script>
        <script src="js/jquery-3.2.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    </body>
</html>