<main class="login-main">
    <section class="login-1">
        <h1>Connexion</h1>
        <div class="connexion-form">
            <form action="index.php?action=loginUser" method="POST">

                <label for="email">Adresse email</label>
                <input class="text-input" id="email" type="email" name="email">

                <label for="password">Mot de passe</label>
                <input class="text-input" id="password" type="password" name="password">

                <input class="green-button submit-button" type="submit" value="Se connecter">
            </form>
        </div>
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">' . $_GET['error'] . '</p>';
        }
        if (isset($_GET['success'])) {
            echo '<p class="success">' . $_GET['success'] . '</p>';
        }
        ?>

        <div class="accountless">
            Pas encore de compte ? <a href="index.php?action=registerForm">Inscrivez-vous</a>
        </div>
    </section>
    <section class="login-2">
        <img src=".\img\bookshell.jpg" alt="Biblio">
    </section>
</main>
