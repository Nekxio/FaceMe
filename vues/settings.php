<div id="formIn__fond" >
    <p id="formIn__title">Je modifie mes données :</p>
    <div id="signUp__fond">
        <form action="index.php?action=form_settings" method="POST" id="signUp__main"> 
            <input type="text" placeholder="Nom complet" class="signUp__input" id="formName" name="name" required>
            <input type="email" placeholder="E-mail" class="signUp__input" id="formMail" name="email" required>
            <input type="password" placeholder="Mot de passe" class="signUp__input" id="formPwd1" minlength='8' pattern='(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$' name="PASSWORD" required>
            <input type="password" placeholder="Confirmer votre mot de passe" class="signUp__input" id="formPwd2" minlength='8' pattern='(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$' name="PASSWORD2" required>
            <input type="file" name="avatar">
            <input type="file" name="background">
            <input type="text" placeholder="biographie" class="signUp__input" id="formBio" name="bio" required>
            <input type="submit" value="Mettre à jour !" class="form__submit" id="signUp__submit">
        </form>
    </div>
</div>