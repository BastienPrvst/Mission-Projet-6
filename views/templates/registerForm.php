<h1>Inscription</h1>


<div class="register-form">
    <form action="index.php?action=registerUser" method="POST">

        <label for="register-pseudo">Pseudo</label>
        <input id="register-pseudo" type="text" name="register-pseudo">

        <label for="register-email">Adresse email</label>
        <input id="register-email" type="email" name="register-email">

        <label for="password">Mot de passe</label>
        <input id="password" type="password" name="password">

        <input type="submit" value="S'inscrire">
    </form>
</div>

<?php
if (!empty($errors)) {
    foreach ($errors as $error) { ?>
        <p> <?=$error ?> </p>
    <?php }
}
?>

<div class="accountless">
    Deja inscrit ? <a href="index.php?action=loginForm">Connectez-vous</a>
</div>