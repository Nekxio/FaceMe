<?PHP
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

	if ($pwd_check) {

		if ($email_check == true) {
			$sql="INSERT INTO user (name, mdp, email) VALUES (?,PASSWORD(?),?)";

			$q = $pdo->prepare($sql);
			$q->execute(array($_POST['name'],$_POST['PASSWORD'],$_POST['email']));
			echo "Le compte est créé ";
		}
	}else {
		if ($email_check = false) {
			echo "L'adresse email '$email' est considérée comme invalide.";
			header('Location : index.php?action=create').reload(true);
		}
		elseif ($pwd_check == false) {
			echo 'Mot de passe différent';
			header('Location : index.php?action=create').reload(true);
		};
	};
}
	
?>