<?php

$sql = "SELECT * FROM user WHERE login=? AND mdp=PASSWORD(?)";

$q = $pdo->prepare($sql);
	$q->execute(array($_POST['login'],$_POST['PASSWORD']));
	$line = $q->fetch();     

    if ($line == false) {
        header('Location: index.php?action=login');
    }else {
        session_start();
        $_SESSION['id'] = $line['id'];
        $_SESSION['login'] = $_POST['login'];
        header('Location: index.php?action=accueil');
    }

// sinon on crée les variables de session $_SESSION['id'] et $_SESSION['login'] et on va à la page d'accueil

?>