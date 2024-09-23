

<div class="back-title">
    <a class="go-back" href="index.php?action=personalProfile"><i class="fa-solid fa-arrow-left"></i> Retour</a>

    <h1 class="add-book-title">Modifier un livre</h1>
</div>

<section class="add-book-form-section">

    <div class="add-book-pic">
        <p class="foto">Photo</p>
        <img src=".\books_img\<?= $book['image'] ?>" alt="">

        <input form="create-book" type="hidden" name="MAX_FILE_SIZE" value="2048000">
        <input form="create-book" type="file" name="picture" id="picture" accept="image/jpeg, image/png" >

    </div>

    <div class="add-book-form-div">
        <form action="index.php?action=addBook" id="create-book" method="post" class="add-book-form" enctype="multipart/form-data" >
            <label for="title">Titre</label>
            <input class="text-input gray" type="text" id="title" name="title" value="<?= htmlentities($book['title'])?>">

            <label for="author">Auteur</label>
            <input class="text-input gray" type="text" id="author" name="author" value="<?= htmlentities($book['author'])?>" >

            <label for="description">Description</label>
            <textarea class="textarea-input" rows="15" id="description" name="description" ><?= htmlentities($book['description'])?></textarea>

            <label for="disponibility">Disponibilité</label>
            <select class="text-input gray" name="disponibility" id="disponibility">
                <option value="1" <?= $book['statut'] == 1 ? 'selected' : '' ?>>Disponible</option>
                <option value="0" <?= $book['statut'] == 0 ? 'selected' : '' ?>>Non-disponible</option>
            </select>


            <input class="green-button submit-button" type="submit" value="Valider">

        </form>
        <?php
        if (!empty($errors)) {
            foreach ($errors as $error) { ?>
                <p> <?=$error ?> </p>
            <?php }
        }
        ?>
    </div>
</section>