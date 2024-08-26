<?php

class UserRepository extends AbstractEntityManager
{

    public function createUser(string $pseudo, string $email, string $password): null|array
    {
        $errors = $this->checkFields($pseudo, $email, $password);

        //Création du USER en BDD
        //Si pas d'erreurs

        if (count($errors) === 0){

            // Hashage du password

            $hashedPassword = password_hash($password,PASSWORD_BCRYPT);

            $userSql = "INSERT INTO users (pseudo, email, password, avatar) VALUES (:pseudo, :email, :password, null)";

            $this->db->query($userSql, [
                'pseudo' => $pseudo,
                'email' => $email,
                'password' => $hashedPassword,
            ]);

            return null;

        }
        return $errors;
    }

    public function connectUser(string $email, string $password): User|false
    {
        $checkSQL = <<<EOD
                    SELECT *
                    FROM users
                    WHERE email = '$email'
                    EOD;

        $user = $this->db->query($checkSQL)->fetch();

        if ($user === false) {
            return false;
        }

        $newUser = new User($user);
        $passwordToTest = $newUser->getPassword();

        if (password_verify($password, $passwordToTest)){
            return $newUser;
        }

        return false;

    }

    public function updateUser(User $currentUser, string $newPseudo, string $newEmail, ?string $newPassword = null): array
    {
        // Recuperation valeurs actuelles
        $id = $currentUser->getId();
        $pseudoToInitialize = $currentUser->getPseudo();
        $emailToInitialize = $currentUser->getEmail();
        $passwordToInitialize = $this->getCurrentPasswordByEmail($emailToInitialize);
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
                $passwordToInitialize = $newPassword;
            }
        }

        $validationForm = $this->checkFields($pseudoToInitialize, $emailToInitialize, $passwordToInitialize);

        if ($validationForm) {
            $errors = array_merge($errors, $validationForm);
        }

        if (!empty($errors)) {
            return $errors;
        }

        $passwordToInitialize = password_hash($passwordToInitialize, PASSWORD_BCRYPT);
        $updateUser = <<<EOD
                UPDATE users
                SET pseudo = '$pseudoToInitialize',
                email = '$emailToInitialize',
                password = '$passwordToInitialize'
                WHERE id = '$id';
                EOD;
        $this->db->query($updateUser);

        $_SESSION['user'] = [
            'id' => $id,
            'email' => $emailToInitialize,
            'pseudo' => $pseudoToInitialize,
        ];

        return [];
    }



    private function getCurrentPasswordByEmail(string $email): ?string
    {
        $query = <<<EOD
        SELECT password
        FROM users
        WHERE email = '$email';
        EOD;

        $queryResult = $this->db->query($query);
        $result = $queryResult->fetch();

        return $result ? $result['password'] : null;
    }

    private function checkFields(string $pseudo, string $email, string $password): array
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

    private function checkEmailExists(string $email): bool
    {
        $emailSql = "SELECT * FROM users WHERE email = :email";
        return $this->db->query($emailSql, ['email' => $email])->rowCount() > 0;
    }

    private function checkPseudoExists(string $pseudo): bool
    {
        $pseudoSql = "SELECT * FROM users WHERE pseudo = :pseudo";
        return $this->db->query($pseudoSql, ['pseudo' => $pseudo])->rowCount() > 0;
    }

    public function updateAvatar(User $user) : array| null
    {
        //On met le vrai MIMETYPE
        $_FILES['picture']['type'] = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $_FILES['picture']['tmp_name']);

        if ($_FILES['picture']['type'] !== 'image/jpeg' && ($_FILES['picture']['type'] !== ('image/png')) && $_FILES['picture']['type'] !== 'image/jpg'){

            $errorMessages[] = 'Le type de fichier n\'est pas valide';
            return $errorMessages;
        }

        if (isset($_FILES['file']) && $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            $error = $_FILES['file']['error'];
            $errorMessages = [];

            if ($error === UPLOAD_ERR_INI_SIZE) {
                $errorMessages[] = "Le fichier dépasse la taille maximale autorisée par upload_max_filesize dans php.ini.";
            }

            if ($error === UPLOAD_ERR_FORM_SIZE) {
                $errorMessages[] = "Le fichier dépasse la taille maximale autorisée par le formulaire HTML.";
            }

            if ($error === UPLOAD_ERR_PARTIAL) {
                $errorMessages[] = "Le fichier n'a été que partiellement téléchargé.";
            }

            if ($error === UPLOAD_ERR_NO_FILE) {
                $errorMessages[] = "Aucun fichier n'a été téléchargé.";
            }

            if ($error === UPLOAD_ERR_NO_TMP_DIR) {
                $errorMessages[] = "Le dossier temporaire est manquant.";
            }

            if ($error === UPLOAD_ERR_CANT_WRITE) {
                $errorMessages[] = "Échec de l'écriture du fichier sur le disque.";
            }

            if ($error === UPLOAD_ERR_EXTENSION) {
                $errorMessages[] = "Une extension PHP a arrêté le téléchargement du fichier.";
            }
        }

        if (!empty($errorMessages)){
            return $errorMessages;
        }

        if ($_FILES['picture']['type'] === 'image/jpeg' || $_FILES['picture']['type'] === 'image/jpg')
        {   $type = '.jpeg';
        }else{
            $type = '.png';
        }

        //On sauvegarde l'image dans notre dossier d'image
        $userId = $user->getId();
        $uploadDir = dirname(__DIR__, 2) . '/users_img/';
        $newName = 'user' . $userId . $type;
        move_uploaded_file($_FILES['picture']['tmp_name'], $uploadDir . $newName);

        //On set le nom en bdd (au moins pour la premiere fois)
        $query = <<<EOD
                UPDATE users
                SET avatar = '$newName'
                WHERE id = '$userId';
        EOD;
        $this->db->query($query);

        //Maj de _SESSION
        $_SESSION['user']['avatar'] = $newName;

        unset($_FILES);

        return null;
    }



}