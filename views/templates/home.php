

<section class="home1">
    <div class="container">
        <div class="part-1">
            <h1>Rejoignez nos lecteurs passionnés</h1>

            <p>Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture. Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres. </p>

            <button class="green-button"><a href="index.php?action=bookList">Découvrir</a></button>
        </div>

        <figure>
            <img src="img/men_reading.jpg" class="sit-man" alt="Un homme lisant entouré de livres.">
            <figcaption>Hamza</figcaption>
        </figure>
    </div>
</section>

<section class="home2">
    <div class="container">
        <h2 class="last-books">Les derniers livres ajoutés</h2>

        <div class="quator">
            <?php foreach ($lastBooks as $lastBook):?>
                <div class="info-books">

                    <img src=".\books_img\<?= htmlentities($lastBook['image']) ?>" class="home-book-img" alt="livre">
                    <div class="detail-books">
                        <span class="title"><?=htmlentities($lastBook['title'])?></span>

                        <span class="author"><?= htmlentities($lastBook['author'])?></span>

                        <span class="seller"> Vendu par : <?= htmlentities($lastBook['pseudo'])?></span>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>

        <button class="green-button center-button"><a href="index.php?action=bookList">Voir tous les livres</a></button>
    </div>
</section>

<section class="home3">
    <div class="container">
        <h2 class="last-books">Comment ça marche ?</h2>
        <p class="trade-books">Échanger des livres avec TomTroc c’est simple et amusant ! Suivez ces étapes pour commencer :</p>

        <div class="quatro">
            <div class="solo">
                <p>Inscrivez-vous gratuitement sur
                    notre plateforme</p>
            </div>

            <div class="solo">
                <p>Ajoutez les livres que vous souhaitez échanger à votre profil.</p>
            </div>

            <div class="solo">
                <p>Parcourez les livres disponibles chez d'autres membres.</p>
            </div>

            <div class="solo">
                <p>Proposez un échange et discutez avec d'autres passionnés de lecture.</p>
            </div>
        </div>

        <button class="green-button center-button"><a href="index.php?action=bookList">Voir tous les livres</a></button>
    </div>
</section>

<div>
    <img src="img/page_banner.jpg" class="banner" alt="Image bannière">
</div>

<section class="home4">
    <div class="container">
        <div class="center-div">
        <h3>Nos valeurs</h3>
            <p>Chez Tom Troc, nous mettons l'accent sur le partage, la découverte et la communauté. Nos valeurs sont ancrées dans notre passion pour les livres et notre désir de créer des liens entre les lecteurs. Nous croyons en la puissance des histoires pour rassembler les gens et inspirer des conversations enrichissantes.</p>
            <br>
            <p>Notre association a été fondée avec une conviction profonde : chaque livre mérite d'être lu et partagé.</p>
            <br>
            <p>Nous sommes passionnés par la création d'une plateforme conviviale qui permet aux lecteurs de se connecter, de partager leurs découvertes littéraires et d'échanger des livres qui attendent patiemment sur les étagères</p>
            <br>
            <p>L’équipe Tom Troc</p>
        </div>
        <img src="img/heart.png" class="keur" alt="Image keur">
    </div>
</section>
