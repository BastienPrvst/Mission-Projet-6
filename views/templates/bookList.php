

<h1>Nos livres à l'échange</h1>

    <label>
        <input type="text" name="search" placeholder="Rechercher un livre">
    </label>

<section class="bookshell">
    <?php foreach ($books as $book): ?>
    <div>
        <ul>
            <li>Titre : <?= $book['title'] ?></li>
            <li>Auteur : <?= $book['author'] ?></li>
            <li>Vendu par : <?= $book['pseudo'] ?></li>
        </ul>
    </div>

    <?php endforeach; ?>

</section>