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
        <link href="data:image/x-icon;base64,AAABAAEAEBAAAAEACABoBQAAFgAAACgAAAAQAAAAIAAAAAEACAAAAAAAAAEAAAAAAAAAAAAAAAEAAAAAAADr6+sASLj+ACgoKADq6uoAJycnACUoJgAkJyoAR7r/AOnp6QAqJCgAJiYmAEa4/wArJCMARrn+ACwsLADo6OgAJSUlACYnIABGuv0A7e3tACAoJQAqKioA5ubmAEO5/wBEuf8AIyMjAEW5/wBHuf8A7OzsAEi5/wBDu/0AKSkpAEW3/wBGt/8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACgoKCgoKCgoKCgoKCgoKCgoKCgoKCgMAAAAKCgoKCgoKCgoKAAAAAAAAAAAQCgoKCgofAAAAHwoKEAAAABkKCgoKAAAACgoKCgoOAAAACgoKCAADAAAKCgoVAAAAAA8KCgAAChYAAAQZAAAEAgAACgoAAAoKCgAAAAAECgoAAAoKAAAKCgocAAAcCgoKAAAKCgAACgoKEAAAEAoKCgAACgocAAQKCgoTEwoKCgoAAwoKCgAACgoKCgoKCgoAAAoKCgoPACAgCgoKCiAgAA8KCgoKCgYBGxgaFyEbDREKCgoKCgoKCQsgHRIeBwwKCgoKCgoKCgoKChQFCgoKCgoKCgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=" rel="icon" type="image/x-icon" />
        <title>FaceMe | Le réseau social MMI</title>
        <link href="./css/style.css" rel="stylesheet">
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
                    echo "<header>
                                <h1>FaceMe</h1>
                            </header>";
                    echo $_SESSION['login']." <a href='index.php?action=deconnexion'>Deconnexion</a>";
                }else {
                    echo "
                    <div id='container'>
                        <!-- zone de connexion -->
                        <h1>Se Connecter</h1>
                        <form action='index.php?action=connexion' method='POST'>
                                     
                            <label><b>Nom d'utilisateur</b></label>
                            <input type='text' placeholder='Identifiant' name='login' required>

                            <label><b>Mot de passe</b></label>
                            <input type='password' placeholder='Mot de passe' name='PASSWORD' required>

                            <input type='submit' id='submit' value='Me connecter' >
                        </form>
                        <a href='index.php?action=create_account'>Créer un compte</a></li>
                    ";
                }
                ?>
            </ul>
        </nav>

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

        <footer>Le pied de page</footer>
        <script src="js/jquery-3.2.1.min.js"></script>
    </body>
</html>
