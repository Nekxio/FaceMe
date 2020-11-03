<form action="index.php?action=form_account" method="POST">
    <h1>Créer un compte</h1>
                
    <label><b>Nom d'utilisateur</b></label>
    <input type="text" placeholder="Entrer le nom d'utilisateur" name="login" required>

    <label><b>Mot de passe</b></label>
    <input minlength='8' pattern='(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$' type="password" placeholder="Entrer le mot de passe" name="PASSWORD" required>

    <label><b>Répétez le mot de passe</b></label>
    <input minlength='8' pattern='(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$' type="password" placeholder="Entrer le mot de passe" name="PASSWORD2" required>

    <label><b>adresse email</b></label>
    <input type="mail" placeholder="Entrer l'adresse email" name="email" required>

    <input type="submit" id='submit' value='Créer un compte' >
</form>