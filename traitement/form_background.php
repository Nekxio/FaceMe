<?php
sleep(2);
    if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la pgae de login
        header("Location:index.php?action=login");
    }
		include('upload_background.php');
		$sql4="UPDATE user set background=? WHERE id=?";
		$q4 = $pdo->prepare($sql4);
		$q4->execute(array($target_file_background, $_SESSION['id']));
		echo "Le compte a été mis à jour ! ";
		header('Location: ' . $_SERVER["HTTP_REFERER"] );
?>