
<h1>Connexion</h1>


<div class="connexion-form">
    <form action="index.php?action=loginUser" method="POST">

        <label for="email">Adresse email</label>
        <input id="email" type="email" name="email">

        <label for="password">Mot de passe</label>
        <input id="password" type="password" name="password">

        <input type="submit" value="Se connecter">
    </form>
</div>

<div class="accountless">
    Pas encore de compte ? <a href="index.php?action=registerForm">Inscrivez-vous</a>
</div>