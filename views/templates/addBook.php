

<div class="back-title">
    <a class="go-back" href="index.php?action=personalProfile"><i class="fa-solid fa-arrow-left"></i> Retour</a>

    <h1 class="add-book-title">Ajouter un livre</h1>
</div>

<section class="add-book-form-section">

    <div class="add-book-pic">
        <p class="foto">Photo</p>
        <img src=".\img\men_reading.jpg" alt="">

            <input form="create-book" type="hidden" name="MAX_FILE_SIZE" value="2048000">
            <input form="create-book" type="file" name="picture" id="picture" accept="image/jpeg, image/png" >

    </div>

    <div class="add-book-form-div">
        <form action="index.php?action=addBook" id="create-book" method="POST" class="add-book-form" enctype="multipart/form-data" >
            <label for="title">Titre</label>
            <input required class="text-input gray" type="text" id="title" name="title">

            <label for="author">Auteur</label>
            <input required class="text-input gray" type="text" id="author" name="author">

            <label for="description">Description</label>
            <textarea required class="textarea-input" rows="15" name="description" id="description"></textarea>

            <label for="disponibility">Disponibilité</label>
            <select class="text-input gray" name="disponibility" id="disponibility">
                <option value="1">Disponible</option>
                <option value="0">Non-disponible</option>
            </select>

            <input class="green-button" type="submit" value="Valider">

        </form>
    </div>
</section>