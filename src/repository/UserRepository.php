<?php

class UserRepository extends AbstractEntityManager
{

    public function createUser(string $pseudo, string $email, string $password): null|array
    {
        if (isset($pseudo, $email, $password)) {
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

            // Hashage du password

            $hashedPassword = password_hash($password,PASSWORD_BCRYPT);

            //Création du USER en BDD
            //Si pas d'erreurs
            if (!isset($errors)){
                $userSql = "INSERT INTO users (pseudo, email, password, avatar) VALUES (:pseudo, :email, :password, null)";

                $this->db->query($userSql, [
                    'pseudo' => $pseudo,
                    'email' => $email,
                    'password' => $hashedPassword
                ]);

                return null;

            }else{
                return $errors;
            }

        }else{
            $errors[] = 'Veuillez remplir les champs';
            return $errors;
        }

    }

    public function connectUser(string $email, string $password): User|false
    {
        $checkSQL = <<<EOD
        SELECT *
        FROM users
        WHERE email = '$email'
        EOD;

        $result = $this->db->query($checkSQL);

        while ($user = $result->fetch()) {
            $newUser = new User($user);
            $passwordToTest = $newUser->getPassword();
            if (password_verify($password, $passwordToTest)){
                return $newUser;
            }

            return false;
        };

        return false;

    }


}