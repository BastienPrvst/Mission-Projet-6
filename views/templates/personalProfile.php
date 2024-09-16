
<main class="main-profil">
    <h1 class="account">Mon compte</h1>
    <div class="flex-it">
        <section class="first-profile-section">
            <div class="personal-image">
                <?php
                if (isset($_SESSION['user']['avatar'])) { ?>
                    <img class="user-img" src="users_img/<?=htmlentities($_SESSION['user']['avatar'])?>" alt="test">
                <?php
                }else{ ?>
                    <img class="user-img" src="img/default_image.png" alt="Image par défaut du site Tom Troc">
                <?php
                }
                ?>

                <form action="index.php?action=modifyAvatar" method="POST" enctype="multipart/form-data">

                    <!-- Champ caché indiquant la taille maximum autorisée pour le fichier -->
                    <input type="hidden" name="MAX_FILE_SIZE" value="2048000">

                    <!-- Champ du fichier, n'acceptant que les fichiers jpg et png -->
                    <input type="file" name="picture" accept="image/jpeg, image/png" value="Modifier">

                    <input type="submit">

                </form>



            </div>
            <div class="user-stats">
                <hr>

                <h2><?= htmlentities($_SESSION['user']['pseudo']) ?></h2>

                <p>Membre depuis XXXXX</p>

                <span>Bibliotheque</span>

                <p><?= count($userBooks)?> Livres</p>
            </div>
        </section>

        <section class="personal-infos">

            <p class="info-perso">Vos informations personnelles</p>
            <div class="connexion-form info-form">
                <form action="index.php?action=modifyProfile" method="POST">
                    <label for="user-email">Adresse email</label>
                    <input class="text-input" id="user-email" name="user-email" type="email" value="<?= htmlentities($_SESSION['user']['email']) ?>">

                    <label for="password">Mot de passe</label>
                    <input class="text-input" id="password" name="password" type="password"
                           placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;">

                    <label for="user-pseudo">Pseudo</label>
                    <input class="text-input" name="user-pseudo" id="user-pseudo" type="text" value="<?= htmlentities($_SESSION['user']['pseudo']) ?>">

                    <input class="green-button submit-button" type="submit" value="Enregistrer">
                </form>
            </div>

            <?php
            if (!empty($errors)) {
                foreach ($errors as $error) { ?>
                    <p> <?=$error ?> </p>
                <?php }
            }
            ?>


        </section>
    </div>

    <section class="user-books">

        <a href="index.php?action=addBookForm"><button>Ajouter un livre </button></a>


        <?php if (!empty($userBooks))
        { ?>
            <table class="user-books-table">
                <thead>
                    <tr>
                        <th scope="col">PHOTO</th>
                        <th scope="col">TITRE</th>
                        <th scope="col">AUTEUR</th>
                        <th scope="col">DESCRIPTION</th>
                        <th scope="col">DISPONIBILITE</th>
                        <th scope="col">ACTION</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    foreach ($userBooks as $book) {?>
                        <tr>
                            <td><img class="book-img" src="img_books/<?= htmlentities($book['image'])?>" alt=""></td>
                            <td><?= htmlentities($book["title"])?></td>
                            <td><?= htmlentities($book['author'])?></td>
                            <td><?= htmlentities($book['description'])?></td>
                            <td><?= htmlentities($book['statut'])?></td>
                            <td>Modifier | Supprimer</td>

                        </tr>



                    <?php
                    }
        }else{ ?>

            <p>Aucun livre à afficher, commencez à en ajouter en cliquant sur le bouton + !</p>

        <?php
        }
            ?>
            </tbody>
        </table>

    </section>
</main>