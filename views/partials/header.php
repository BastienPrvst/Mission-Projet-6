
<header>
    <nav>
        <a href="index.php?action=home"><img class="nav-logo" src="img\logo.png" alt="Logo de Tom Troc"></a>
        <div class="nav-ul">
            <ul>
                <li><a href="index.php?action=home">Accueil</a></li>
                <li><a href="index.php?action=bookList">Nos livres à l'échange</a></li>
                <?php if (isset($_SESSION['user'])) {
                echo '<li><a href="#">Messagerie</a></li>';
                echo '<li><a href="index.php?action=personnalProfile">Mon compte</a></li>';
                echo '<li><a href="index.php?action=logout">Déconnexion</a></li>';
                }else{
                    echo '<li><a href="index.php?action=loginForm">Connexion</a></li>';
                }
                ?>

            </ul>
        </div>
    </nav>
</header>