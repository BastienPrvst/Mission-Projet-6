
<main class="flex-main">
    <section class="twenty-five">

        <img src="./users_img/<?=$user->getAvatar()?>" alt="">

        <p><?= htmlentities($user->getPseudo()) ?></p>
        <p>Membre depuis le <?= date('d-m-Y', strtotime($user->getCreationDate())) ?></p>
        <p><?= count($userBooks)?> livres</p>
        <a href="#"><button class="green-button submit-button">Écrire un message</button></a>


    </section>





    <section class="seventy-five">

        <?php if (!empty($userBooks)) : ?>
        <table>
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