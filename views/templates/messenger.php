

<main class="main-messenger">

    <!--Foreach personnes differentes -->
    <section class="display-all-conversations">
        <h1 class="h1-messenger">Messagerie</h1>

        <?php if (!empty($allDistinctUserMessages)) : ?>
            <?php foreach ($allDistinctUserMessages as $userMessage) : ?>

                <a class="message-preview" href="index.php?action=messageUser&id=<?=htmlentities($userMessage['other']) ?>">
                    <img class="med-img" src="./users_img/<?= $userMessage['avatar'] ?? 'default_user.png' ?>" alt="Avatar d'utilisateur">
                    <div class="message-preview-info">
                        <div class="preview-header">
                            <p class="preview-username"><?= htmlentities($userMessage['pseudo']) ?></p>
                            <p class="preview-date"><?= date_format(new \DateTime($userMessage['date']), 'H:i') ?></p>
                        </div>
                        <p class="preview-text"><?= htmlentities(substr($userMessage['text'], 0, 20))?></p>
                    </div>

                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Pas encore de conversation avec des utilisateurs.</p>
        <?php endif; ?>
    </section>

    <section class="conversation">

            <?php if ($conversation !== null) : ?>
                <div class="title-user">
                    <img class="med-img" src="./users_img/<?= $userAvatar ?>" alt="Photo de profil de l'utilisateur actif">
                    <h2 class="user-msg-pseudo"><?= $userPseudo ?></h2>
                </div>
            <?php endif; ?>
            <div class="conv-box">
            <?php if ($conversation !== null) : ?>
                <?php foreach ($conversation as $message) : ?>
                    <?php if (!empty($message->avatar)) : ?>
                        <div class="message-from-user">
                            <div class="image-date">

                                <img class="very-smol-img" src="./users_img/<?= $message->avatar ?>" alt="Avatar utilisateur">

                                <p class="preview-date"><?= date_format($message->getDate(), 'd/m H:i') ?></p>
                            </div>
                            <p class="msg-text"><?= htmlentities($message->getText()) ?></p>
                        </div>
                    <?php else : ?>
                        <div class="message-from-me">
                            <div class="image-date">
                                <p class="preview-date"><?= date_format($message->getDate(), 'd/m H:i') ?></p>
                            </div>
                            <p class="msg-text"><?= htmlentities($message->getText()) ?></p>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>

                <p class="start-chat">Vous n'avez pas de discussions en cours ! !</p>

            <?php endif; ?>
        </div>

        <form class="message-form" action="index.php?action=sendMessage&targetId=<?= $id ?>" method="post">
            <input class="send-msg-input" type="text" name="msg" id="msg" placeholder="Tapez votre message ici">
            <input class="msg-submit" type="submit">
        </form>
    </section>
</main>



