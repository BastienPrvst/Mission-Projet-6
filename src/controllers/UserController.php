<?php

class UserController
{

    public function registerForm() : void
    {

        $view = new View("S'inscrire");
        $view->render('registerForm');

    }

    public function registerUser() : void
    {
        $pseudo = Utils::request("register-pseudo");
        $email = Utils::request("register-email");
        $password = Utils::request("password");

        $errors = $this->checkFields($pseudo, $email, $password);

        // Hashage du password

        if (count($errors) === 0){

            $hashedPassword = password_hash($password,PASSWORD_BCRYPT);

            (new UserRepository())->createUser($pseudo,$email ,$hashedPassword);

            Utils::redirect('loginForm',
                ['success' => 'Votre compte à bien été crée']);
        }

        Utils::redirect('registerForm',
        ['errors' => $errors]);
    }

    public function logInPage() : void
    {
        $view = new View("Connexion");
        $view->render('loginForm');
    }

    /**
     * @throws Exception
     */
    public function logInUser() : void
    {
        $email = Utils::request("email");
        $password = Utils::request("password");

        if ($email === null || $password === null) {
            return;
        }

        $user = (new UserRepository())->connectUser($email, $password);

        //Si aucun utilisateur avec ce mail ou mdp incorrect
        if ($user === false){
            Utils::redirect("loginForm",
                ['error' => 'Le pseudo et/ou le mot de passe est incorrect' ]);
        }

        // On connecte l'utilisateur.
        $_SESSION['user'] = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'pseudo' => $user->getPseudo(),
            'avatar' => $user->getAvatar(),
            'creationDate' => $user->getCreationDate(),
        ];

        Utils::redirect("personalProfile");
    }

    public function logOut() : void
    {
        unset($_SESSION['user']);

        Utils::redirect("home");
    }

    public function showPersonalProfile() : void
    {
        if (!isset($_SESSION['user'])){
            Utils::redirect("home");
        }

        $id = $_SESSION['user']['id'];

        $user = (new UserRepository())->getUserById($id);

        if ($user === null){
            Utils::redirect('home');
        }

        $userBooks = (new BookRepository())->findBookByUser($user);

        $view = new View("Mon profil");
        $view->render('personalProfile',
        [
            'user' => $user,
            'userBooks' => $userBooks
        ]);
    }

    public function modifiyUserInfo() : void
    {
        //Données du form
        $newPseudo = Utils::request("user-pseudo");
        $newEmail = Utils::request("user-email");
        $newPassword = Utils::request("password");

        // Recuperation valeurs actuelles
        $id = ($_SESSION['user']['id']);

        $user = (new UserRepository())->getUserById($id);

        $pseudoToInitialize = $user->getPseudo();
        $emailToInitialize = $user->getEmail();
        $passwordToInitialize = (new UserRepository())->getCurrentPasswordByEmail($emailToInitialize);
        $errors = [];

        if ($newPseudo !== $pseudoToInitialize){
            $pseudoToInitialize = $newPseudo;
        }
        if ($newEmail !== $emailToInitialize){
            $emailToInitialize = $newEmail;
        }
        if ($newPassword && !password_verify($newPassword, $passwordToInitialize)){
            if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,4096}$/", $newPassword)){
                $errors[] = 'Votre mot de passe doit contenir au moins 8 caractères dont une lettre et un chiffre.';
            }else{
                $passwordToInitialize = password_hash($newPassword, PASSWORD_BCRYPT) ;
            }
        }

        $validationForm = $this->checkFields($pseudoToInitialize, $emailToInitialize, $passwordToInitialize);

        if ($validationForm) {
            $errors = array_merge($errors, $validationForm);
        }

        if (!empty($errors)) {
            $view = new View("Mon profil");
            $view->render('personalProfile',
                ['errors' => $errors]);
        }

        (new UserRepository())->updateUser($id, $pseudoToInitialize, $emailToInitialize, $passwordToInitialize);
        Utils::redirect("personalProfile");

    }

    public function modifyAvatar() : void
    {
        $user = new User();
        $user->setPseudo($_SESSION['user']['pseudo']);
        $user->setEmail($_SESSION['user']['email']);
        $user->setId($_SESSION['user']['id']);
        $user->setAvatar($_SESSION['user']['avatar']);

        $errors = (new UserRepository())->updateAvatar($user);

        if (!empty($errors)){
            $view = new View("Mon profil");
            $view->render('personalProfile',
            ['errors' => $errors]);
        }

        //Redirection si pas d'erreurs dans le formulaire
        Utils::redirect("personalProfile");

    }

    public function showUserProfile() : void
    {
        $id = Utils::request('id');
        $user = (new UserRepository())->getUserById($id);
        if ($user === null){
            Utils::redirect('home');
        }
        $userBooks = (new BookRepository())->findBookByUser($user);
        $view = new View("Profil d'utilisateur");
        $view->render('userProfile',[
            'user' => $user,
            'userBooks' => $userBooks,
        ]);
    }

    /**
     * @throws Exception
     */
    public function messageUser(): void
    {
        $userId = $_SESSION['user']['id'];

        //Toutes les conversations sur le coté

        $allDistinctUserMessages = (new MessageRepository())->retrieveAllDistinctMessages($userId);

        if (!empty($allDistinctUserMessages)){

            foreach ($allDistinctUserMessages as &$userMessage){

                $userMessage ['avatar'] = (new UserRepository())->getUserById($userMessage['other'])->getAvatar();

            }
            unset($userMessage);
        }

        //Conversation en cours

        $id = Utils::request('id');

        //Si jamais l'utilisateur clique juste sur "messagerie", c'est celui de la dernière conversation qui est utilisé

        if ($id === null){
            $id = $allDistinctUserMessages[0]['other'] ?? null;
        }

        if ($id !== null){
            $user = (new UserRepository())->getUserById($id);

            $userPseudo = $user?->getPseudo();
            $userAvatar = $user?->getAvatar();

            if ($user !== null){
                $conversation = (new MessageRepository())->retrieveConversation($id, $userId);
                if ($conversation !== null){
                    foreach ($conversation as $message){
                        if ($message->getSendBy() === (int)$id){
                            $message->avatar = $userAvatar;
                        }
                    }
                }

            }else{
                $conversation = null;
            }
        }


        $view = new View("Messagerie");
        $view->render('messenger', [
            'id' => $id ?? null,
            'conversation' => $conversation,
            'userPseudo' => $userPseudo,
            'userAvatar' => $userAvatar,
            'allDistinctUserMessages' => $allDistinctUserMessages,
        ]);
    }

    public function sendMessage() : void
    {
        $targetId = Utils::request("targetId");
        $userId = $_SESSION['user']['id'];
        $message = Utils::request("msg");

        (new MessageRepository())->sendMessage($message,$userId,$targetId);
        Utils::redirect("messageUser", [
            "id" => $targetId,
        ]);
    }


    public function checkFields(string $pseudo, string $email, string $password): array
    {

        $errors = [];
        if (!empty($pseudo)
            && !empty($email)
            && !empty($password)){

            if (empty($_SESSION['user']) || $_SESSION['user']['pseudo'] !== $pseudo){
                if ($this->checkPseudoExists($pseudo)){
                    $errors[] = 'Ce pseudonyme est déjà utilisé';
                }
            }

            if (empty($_SESSION['user']) || $_SESSION['user']['email'] !== $email){
                if ($this->checkEmailExists($email)){
                    $errors[] = 'Cet email est déjà utilisé';
                }
            }

            if (mb_strlen($pseudo) > 50){
                $errors[] = 'Votre pseudonyme ne peut contenir que 50 lettres et/ou chiffres maximum.';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)|| mb_strlen($email) > 200){
                $errors[] = 'L\'adresse email renseignée n\'est pas valide';
            }

            if (empty($_SESSION['user'])){
                if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,4096}$/", $password)){
                    $errors[] = 'Votre mot de passe doit contenir au moins 8 caractères dont une lettre et un chiffre.';
                }
            }

        }else{
            $errors[] = 'Veuillez remplir tous les champs';
        }

        return $errors;

    }

}