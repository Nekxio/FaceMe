<div id="formIn__fond">
    <p id="formIn__title">Je crée mon compte</p>
    <div id="signUp__fond">
        <form action="index.php?action=form_account" method="POST" id="signUp__main"> 
            <input type="text" placeholder="Nom d'utilisateur" class="signUp__input" id="formName" name="login" required>
            <input type="email" placeholder="E-mail" class="signUp__input" id="formMail" name="email" required>
            <input type="password" placeholder="Mot de passe" class="signUp__input" id="formPwd1" minlength='8' pattern='(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$' name="PASSWORD" required>
            <input type="password" placeholder="Confirmer votre mot de passe" class="signUp__input" id="formPwd2" minlength='8' pattern='(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$' name="PASSWORD2" required>
            <input type="submit" value="Que l'aventure commence !" class="form__submit" id="signUp__submit">
            <a href="./login.php">Se connecter</a>
        </form>
    </div>
</div>