<?php
sleep(2);
    if(!isset($_SESSION["id"])) {
        // On n est pas connecté, il faut retourner à la pgae de login
        header("Location:index.php?action=login");
    }
		include('upload_avatar.php');
		include('upload_background.php');
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
		if ($name_check == true) {

			if ($pwd_check == true) {

				if ($email_check == true) {
					$sql4="UPDATE user set name=?, mdp=PASSWORD(?), email=?, bio=? WHERE id=?";
					$q4 = $pdo->prepare($sql4);
					$q4->execute(array($_POST['name'],$_POST['PASSWORD'],$_POST['email'],$_POST['bio'], $_SESSION['id']));
					echo "Le compte a été mis à jour ! ";
				}
			}else {
				if ($email_check = false) {
					echo "L'adresse email '$email' est considérée comme invalide.";
					header('Location: ' . $_SERVER["HTTP_REFERER"] );
				}
				elseif ($pwd_check == false) {
					echo 'Mot de passe différent';
					header('Location: ' . $_SERVER["HTTP_REFERER"] );
				};
			};
			header('Location: ' . $_SERVER["HTTP_REFERER"] );
		}
		
?>