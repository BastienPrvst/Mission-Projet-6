
<header>
    <nav class="container">
        <a href="index.php?action=home"><img class="nav-logo" src="img\logo.png" alt="Logo de Tom Troc"></a>
        <div class="nav-list">
            <ul class="nav-ul1">
                <li class="nav-li1"><a href="index.php?action=home">Accueil</a></li>

                <li class="nav-li1"><a href="index.php?action=bookList">Nos livres à l'échange</a>
                </li>
            </ul>
            <ul class="nav-ul2">
                <?php if (isset($_SESSION['user'])) {
                    echo '<li class="nav-li2"><a href="index.php?action=messageUser"><i class="fa-regular fa-comment"></i> Messagerie</a></li>';
                    echo '<li class="nav-li2"><a href="index.php?action=personalProfile">Mon compte</a></li>';
                    echo '<li class="nav-li2"><a href="index.php?action=logout">Déconnexion</a></li>';
                }else{
                    echo '<li class="nav-li2"><a href="index.php?action=loginForm">Connexion</a></li>';
                }
                ?>

            </ul>
        </div>
    </nav>
</header>