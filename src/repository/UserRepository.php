<?php

class UserRepository extends AbstractEntityManager
{

    public function createUser(User $user, string $password): null|array
    {
        $errors = $this->validateUser($user, $password);

        //Création du USER en BDD
        //Si pas d'erreurs
        if (count($errors) === 0){

            // Hashage du password

            $hashedPassword = password_hash($password,PASSWORD_BCRYPT);

            $userSql = "INSERT INTO users (pseudo, email, password, avatar) VALUES (:pseudo, :email, :password, null)";

            $this->db->query($userSql, [
                'pseudo' => $user->getPseudo(),
                'email' => $user->getEmail(),
                'password' => $hashedPassword,
            ]);

            return null;

        }
        return $errors;
    }

    public function updateUser(User $user, string $pseudo, string $email, ?string $password = null): void
    {
        $id = $user->getId();
        $currentPseudo = $user->getPseudo();
        $currentEmail = $user->getEmail();
        //Recuperation du password en bdd par rapport au mail
        $getCurrentPassword = <<<EOD
                            SELECT password
                            FROM users
                            WHERE email = '$currentEmail';
                            EOD;

        $passwordQuery = $this->db->query($getCurrentPassword);
        $currentPassword = $passwordQuery->fetch();

        if ($currentPseudo !== $pseudo){
            $currentPseudo = $pseudo;
        }

        if ($currentEmail !== $email){
            $currentEmail = $email;
        }

        if
        ($password !== null && password_verify($password, $currentPassword)){
            $currentPassword = $password;
        }

        $user->setPseudo($currentPseudo);
        $user->setEmail($currentEmail);
        $user->setPassword($currentPassword);

        $errors = $this->validateUser($user, $currentPassword);

        if (count($errors) !== 0){
            return;
        }


        $updateUser = <<<EOD
                    UPDATE users
                    SET pseudo = '$currentPseudo', email = '$currentEmail', password = '$currentPassword'
                    WHERE id = '$id';
                    EOD;
        $this->db->query($updateUser);

    }


    private function validateUser(User $user,string $password) : array
    {

        $errors = [];
        $pseudo = $user->getPseudo();
        $email = $user->getEmail();

        if (!empty($pseudo)
            && !empty($email)
            && !empty($password)){
            //Debut des vérifications

            if (mb_strlen($pseudo) > 50){
                $errors[] = 'Votre pseudonyme ne peut contenir que 50 lettres et/ou chiffres maximum.';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)|| mb_strlen($email) > 200){
                $errors[] = 'L\'adresse email renseignée n\'est pas valide';
            }

            if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,4096}$/", $password)){
                $errors[] = 'Votre mot de passe doit contenir au moins 8 caractères dont une lettre et un chiffre.';
            }

            //Vérification si le pseudo/mail est déjà utilisé

            $pseudoSql = "SELECT * FROM users WHERE pseudo = :pseudo";

            $emailSql = "SELECT * FROM users WHERE email = :email";

            if ($this->db->query($pseudoSql, ['pseudo' => $pseudo])->rowCount() > 0){
                $errors[] = 'Le pseudonyme choisi est déjà utilisé';
            }

            if ($this->db->query($emailSql, ['email' => $email])->rowCount() > 0){
                $errors[] = 'Le mail choisi est déjà utilisé';
            }

        }else{
            $errors[] = 'Veuillez remplir tous les champs';

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

        $result = $this->db->query($checkSQL);
        $user = $result->fetch();

        if ($user === false) {
            return false;
        }

        $newUser = new User($user);
        $passwordToTest = $newUser->getPassword();

        if (password_verify($password, $passwordToTest)){
            return $newUser;
        }

        throw new Exception('Pourquoi ca marche paaaaaaaaaaaaaaaaaaaaaaaas');
    }

}