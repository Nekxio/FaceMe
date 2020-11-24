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
        <link href="./icons/logo_faceme.png" rel="icon" type="image/x-icon"/>
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
                                        <p><?= $_SESSION['name']?></p>
                                    </button>
                                    <div id="headerHover__menu">
                                        <ul>
                                            <li><a href="index.php?action=profile&id=<?= $_SESSION['id']?>">Mon Profil</a></li>
                                            <li><a href="index.php?action=settings">Mes Paramètres</a></li>
                                            <li><a href="index.php?action=deconnexion">Se déconnecter</a></li>
                                        </ul>
                                    </div>
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
                            <a href='index.php?action=create_account' class='form__submit' id='signIn__submit' onclick='changement()'>Créer un compte</a>
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
    </body>
</html>