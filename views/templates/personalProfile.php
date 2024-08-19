

<h1>Mon compte</h1>

<section class="first-profile-section">
    <div class="personal-image">
        <?php
        if (isset($_SESSION['avatar'])) { ?>

        <?php
        }else{ ?>
            <img src="img/default_image.png" alt="Image par défaut du site Tom Troc">
        <?php
        }
        ?>

        <a href="#">Modifier</a>
    </div>
</section>

<section class="personal-infos">

    <h2>Vos informations personnelles</h2>

    <form action="index.php?action=modifyProfile" method="POST">
        <label for="user-email">Adresse email</label>
        <input id="user-email" name="user-email" type="email" value="<?= htmlentities($_SESSION['user']['email']) ?>">

        <label for="password">Mot de passe</label>
        <input id="password" name="password" type="password"
               placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;">

        <label for="user-pseudo">Pseudo</label>
        <input name="user-pseudo" id="user-pseudo" type="text" value="<?= htmlentities($_SESSION['user']['pseudo']) ?>">

        <input type="submit" value="Enregistrer">
    </form>


</section>
