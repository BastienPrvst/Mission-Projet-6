


<main class="book-detail">
    <section class="book-half-image">
        <img src="./books_img/<?= $book->getImage() ?>" alt="">
    </section>

    <section class="book-half-info">
        <h1><?= $book->getTitle() ?></h1>
        <p>Par : <?= $book->getAuthor() ?></p>
        <br>
        <hr>
        <h2>Description :</h2>
        <p> <?= $book->getDescription() ?></p>
        <p>Propriétaire :
            <br>
        <?= $user->getPseudo() ?></p>
    </section>

</main>

