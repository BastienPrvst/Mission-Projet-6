


<main class="book-detail">
    <section class="book-half-image">
        <img src="./books_img/<?= $book->getImage() ?>" alt="">
    </section>

    <section class="book-half-info">
        <h1 class="detail-title"><?= htmlentities(ucfirst($book->getTitle())) ?></h1>
        <p class="seller">par <?= htmlentities(ucfirst($book->getAuthor())) ?></p>
        <br>
        <hr class="mini">
        <h2>Description :</h2>
        <p class="description"> <?= htmlentities($book->getDescription()) ?></p>
        <p>Propriétaire :</p>
            <br>
        <div class="user-token">
            <a href="index.php?action=userProfile&id=<?=$user->getId()?>">
                <img class="smol-img" src="./users_img/<?= $user->getAvatar()?>" alt="">
                <p><?= $user->getPseudo() ?></p>
            </a>
        </div>


        <a href="#"><button class="green-button send-msg">Envoyer un message</button></a>

    </section>

</main>

