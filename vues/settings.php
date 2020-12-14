<?php
$sql="SELECT user.* FROM user WHERE user.id=?";
$q = $pdo->prepare($sql);
$q->execute(array($_SESSION['id']));
while($result = $q -> fetch()){;
?>

<section class="container">
    <div>
        <p class="settingsTitle">Je modifie mes données :</p>
        <div class="settingsCard">
            <form action="index.php?action=form_settings" method="POST" enctype="multipart/form-data">
                <div class="settingsCard__flex">
                    <input type="text" placeholder="Nom complet" class="settings__input" id="formName" name="name" value="<?=$result['name']?>" required>
                    <input type="email" placeholder="E-mail" class="settings__input" id="formMail" name="email" value="<?=$result['email']?>" required>
                </div>
                <div class="settingsCard__flex">
                    <input type="password" placeholder="Mot de passe" class="settings__input" id="formPwd1" minlength='8' pattern='(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$' name="PASSWORD" required>
                    <input type="password" placeholder="Confirmer votre mot de passe" class="settings__input" id="formPwd2" minlength='8' pattern='(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$' name="PASSWORD2" required>
                </div>
                <div class="settingsCard__flex">
                    <input type="text" placeholder="biographie" class="settings__input" id="formBio" name="bio" value="<?=$result['bio']?>" required>
                    <input type="submit" value="Mettre à jour" class="settings__submit" onclick="update()">
                </div>
            </form>
        </div>
    </div>
    <div>
        <p class="settingsTitle">Je modifie mon image de profil :</p>
        <div class="settingsCard">
            <form action="index.php?action=form_avatar" method="POST" enctype="multipart/form-data" class="settingsCard__flexSubmit">
                <input type="file" name="avatar" class="settings__inputsFile" id="real_inputSetAvatar" hidden="hidden">
                <button class="post_commentairesIcon" type="button" onclick="fileSetAvatar()">
                    <img src="./src/icons/useradd.svg" alt="icône ajout fichier">
                </button>
                <input type="submit" value="Mettre à jour" class="settings__submit settings__submitSpecial" onclick="update()">
            </form>
        </div>
    </div>
    <div>
        <p class="settingsTitle">Je modifie ma bannière de profil :</p>
        <div class="settingsCard">
            <form action="index.php?action=form_background" method="POST" enctype="multipart/form-data" class="settingsCard__flexSubmit">
                <input type="file" name="background" class="settings__inputsFile" id="real_inputSetBackground" hidden="hidden">
                <button class="post_commentairesIcon" type="button" onclick="fileSetBackground()">
                    <img src="./src/icons/background.svg" alt="icône ajout fichier">
                </button>
                <input type="submit" value="Mettre à jour" class="settings__submit settings__submitSpecial" onclick="update()">
            </form>
        </div>
    </div>
</section>

<?php
}
?>