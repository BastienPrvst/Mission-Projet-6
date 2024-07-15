

<section>
    <h1>Rejoignez nos lecteurs passionnés</h1>

    <p>Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture. Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres. </p>

    <button class="simple-button"><a href="index.php?action=bookList">Découvrir</a></button>
    <figure>
        <img src="img/men_reading.jpg" alt="Un homme lisant entouré de livres.">
        <figcaption>Hamza</figcaption>
    </figure>
    
</section>

<section>

    <h2>Les derniers livres ajoutés</h2>


    <?php foreach ($lastBooks as $lastBook):?>
        <div class="info-books">
            <?=$lastBook['title'];?>

            <?= $lastBook['author'];?>

            <?= $lastBook['description'];?>

            <?= $lastBook['statut'];?>

            <?= $lastBook['pseudo'];?>


        </div>

    <?php endforeach; ?>

    <button class="simple-button"><a href="index.php?action=bookList">Voir tous les livres</a></button>

</section>

<section>

    <h2>Comment ça marche ?</h2>
    <p>Échanger des livres avec TomTroc c’est simple et amusant ! Suivez ces étapes pour commencer :</p>
    
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

    <button class="simple-button"><a href="index.php?action=bookList">Voir tous les livres</a></button>

</section>

<div>
    <img src="img/page_banner.jpg" alt="Image bannière">
</div>

<section>
    <h3>Nos valeurs</h3>
    <p>Chez Tom Troc, nous mettons l'accent sur le partage, la découverte et la communauté. Nos valeurs sont ancrées dans notre passion pour les livres et notre désir de créer des liens entre les lecteurs. Nous croyons en la puissance des histoires pour rassembler les gens et inspirer des conversations enrichissantes.</p>
    <br>
    <p>Notre association a été fondée avec une conviction profonde : chaque livre mérite d'être lu et partagé.</p>
    <br>
    <p>Nous sommes passionnés par la création d'une plateforme conviviale qui permet aux lecteurs de se connecter, de partager leurs découvertes littéraires et d'échanger des livres qui attendent patiemment sur les étagères</p>
    <br>
    <p>L’équipe Tom Troc</p>

    <img src="img/heart.png" alt="Image keur">
</section>
