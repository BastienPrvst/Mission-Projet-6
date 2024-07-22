<h1>Inscription</h1>


<div class="register-form">
    <form action="index.php?action=registerUser" method="POST">
        <label for="pseudo">Pseudo</label>
        <input id="pseudo" type="text" name="pseudo">
        <label for="email">Adresse email</label>
        <input id="email" type="email" name="email">
        <label for="password">Mot de passe</label>
        <input id="password" type="password" name="password">
        <input type="submit" value="S'inscrire">
    </form>
</div>

<div class="accountless">
    Deja inscrit ? <a href="index.php?action=loginForm">Connectez-vous</a>
</div>