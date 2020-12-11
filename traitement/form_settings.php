<?php
	include('./upload_avatar.php');
	include('./upload_background.php');
    if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la pgae de login
        header("Location:index.php?action=login");
    }else{
		
		$q = "SELECT * FROM user WHERE name=?";

		$name = $_POST['name'];
		if ($name == $q) {
			$name_check = false;
		}else{
			$name_check = true;
		}

		$email = $_POST['email'];
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$email_check = true;
		}else{
			$email_check = false;
		}

		$pwd1 = $_POST['PASSWORD'];
		$pwd2 = $_POST['PASSWORD2'];

		if ($pwd1 == $pwd2) {
			$pwd_check = true;
		}else {
			$pwd_check = false;
		}

		if (!empty($target_file_avatar)) {
			$picture_check = true;
		}else {
			$picture_check = false;
		}

		if (!empty($target_file_background)) {
			$background_check = true;
		}else {
			$background_check = false;
		}

		if ($name_check == true) {

			if ($pwd_check == true) {

				if ($email_check == true) {
					if ($picture_check == true && $background_check == true){
					$sql="UPDATE user set name=?, mdp=PASSWORD(?), email=?, avatar=?, background=?, bio=? WHERE id=?".";"."INSERT INTO user (avatar, background) VALUES (?,?) WHERE id=?";

					$q = $pdo->prepare($sql);
					$q->execute(array($_POST['name'],$_POST['PASSWORD'],$_POST['email'],$_SESSION['id'],$target_file_avatar, $target_file_background, $_SESSION['id']));
					echo "Le compte a été mis à jour ! ";
				}elseif($picture_check == true && $background_check == false){
					$sql2="UPDATE user set name=?, mdp=PASSWORD(?), email=?, avatar=?,bio=? WHERE id=? AND background IS NULL";

					$q2 = $pdo->prepare($sql2);
					$q2->execute(array($_POST['name'],$_POST['PASSWORD'],$_POST['email'], $target_file_avatar,$_POST['bio'], $_SESSION['id']));
					echo "Le compte a été mis à jour ! ";
				}elseif($picture_check == false && $background_check == true){
					$sql3="UPDATE user set name=?, mdp=PASSWORD(?), email=?, background=?,bio=? WHERE id=? AND avatar IS NULL";

					$q3 = $pdo->prepare($sql3);
					$q3->execute(array($_POST['name'],$_POST['PASSWORD'],$_POST['email'], $target_file_background,$_POST['bio'], $_SESSION['id']));
					echo "Le compte a été mis à jour ! ";
				}else{
					$sql4="UPDATE user set name=?, mdp=PASSWORD(?), email=?, bio=? WHERE id=? AND avatar IS NULL AND background IS NULL";

					$q4 = $pdo->prepare($sql4);
					$q4->execute(array($_POST['name'],$_POST['PASSWORD'],$_POST['email'],$_POST['bio'], $_SESSION['id']));
					echo "Le compte a été mis à jour ! ";
				}}
			}else {
				if ($email_check = false) {
					echo "L'adresse email '$email' est considérée comme invalide.";
					header('Location : index.php?action=settings').reload(true);
				}
				elseif ($pwd_check == false) {
					echo 'Mot de passe différent';
					header('Location : index.php?action=settings').reload(true);
				};
			};
		}
		header('Location: ' . $_SERVER["HTTP_REFERER"] );
	}
?>