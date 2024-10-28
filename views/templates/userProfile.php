
<main class="flex-main">
    <section class="twenty-five">

        <img class="big-img" src="./users_img/<?=$user->getAvatar()?>" alt="">

        <hr>

        <h2><?= htmlentities($user->getPseudo()) ?></h2>
        <p>Membre depuis le <?= date('d-m-Y', strtotime($user->getCreationDate())) ?></p>
        <p><?= count($userBooks)?> livre(s)</p>
        <a href="index.php?action=messageUser&id=<?=$user->getId()?>"><button class="green-button button-msg">Écrire un message</button></a>


    </section>

    <section class="seventy-five">

        <?php if (!empty($userBooks)) : ?>
        <table class="user-books-table table-profil">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($userBooks as $book) : ?>

                <tr>
                    <td><img class="book-img" src="./books_img/<?= htmlentities($book['image'])?>" alt=""></td>
                    <td><?= htmlentities($book['title'])?></td>
                    <td><?= htmlentities($book['author'])?></td>
                    <td><?= htmlentities($book['description'])?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>Cet utilisateur n'a pas encore ajouté de livre à sa collection</p>
        <?php endif; ?>

    </section>
</main>