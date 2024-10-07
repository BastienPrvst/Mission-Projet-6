
    <div class="book-list-header">
        <h1 class="our-books">Nos livres à l'échange</h1>

        <form action="index.php" method="get">
            <input type="hidden" name="action" value="searchBook">
            <label for="keyword">
                <input type="text" class="search-book" name="keyword" id="keyword" placeholder="Rechercher un livre">
            </label>
            <button type="submit" style="display:none"></button>
        </form>

    </div>
<section class="bookshell">
    <?php
    $booksToDisplay = $result ?? $books;
    ?>

    <?php foreach ($booksToDisplay as $book): ?>
    <a href="index.php?action=bookDetail&id=<?= htmlentities($book['id']) ?>">
        <div class="info-books book-unit">

            <?php
            if ($book['image'] !== NULL) {
                ?>
                <img src=".\books_img\<?= htmlentities($book['image']) ?>" class="home-book-img" alt="livre">
                <?php
            }else{
                ?>
                <img src=".\books_img\default-book.png" class="home-book-img" alt="livre">
                <?php
            }
            ?>
            <div class="detail-books">
                <span class="title"><?=htmlentities($book['title'])?></span>

                <span class="author"><?= htmlentities($book['author'])?></span>

                <span class="seller"> Vendu par : <?= htmlentities($book['pseudo'])?></span>
            </div>
        </div>
    </a>
    <?php endforeach; ?>
</section>