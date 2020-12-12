<?php
$sql="SELECT user.* FROM user WHERE user.id=?";
$q = $pdo->prepare($sql);
$q->execute(array($_SESSION['id']));
while($result = $q -> fetch()){;
?>

<div id="formIn__fond" >
    <p id="formIn__title">Je modifie mes données :</p>
    <div id="signUp__fond">
        <form action="index.php?action=form_settings" method="POST" id="signUp__main" enctype="multipart/form-data">
            <input type="text" placeholder="Nom complet" class="signUp__input" id="formName" name="name" value="<?=$result['name']?>" required>
            <input type="email" placeholder="E-mail" class="signUp__input" id="formMail" name="email" value="<?=$result['email']?>" required>
            <input type="text" placeholder="biographie" class="signUp__input" id="formBio" name="bio" value="<?=$result['bio']?>" required>
            <input type="password" placeholder="Mot de passe" class="signUp__input" id="formPwd1" minlength='8' pattern='(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$' name="PASSWORD" required>
            <input type="password" placeholder="Confirmer votre mot de passe" class="signUp__input" id="formPwd2" minlength='8' pattern='(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$' name="PASSWORD2" required>
            <input type="submit" value="Mettre à jour !" class="form__submit" id="signUp__submit">
        </form>
    </div>
</div>
<div id="formIn__fond" >
    <p id="formIn__title">Je modifie mon image de profil :</p>
    <div id="signUp__fond">
        <form action="index.php?action=form_avatar" method="POST" id="signUp__main" enctype="multipart/form-data">
            <input type="file" name="avatar">
            <input type="submit" value="Mettre à jour !" class="form__submit" id="signUp__submit">
        </form>
    </div>
</div>
<div id="formIn__fond" >
    <p id="formIn__title">Je modifie ma bannière :</p>
    <div id="signUp__fond">
        <form action="index.php?action=form_background" method="POST" id="signUp__main" enctype="multipart/form-data">
            <input type="file" name="background">
            <input type="submit" value="Mettre à jour !" class="form__submit" id="signUp__submit">
        </form>
    </div>
</div>
<?php
}
?>