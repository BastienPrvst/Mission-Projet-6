<?php

use Cassandra\Date;

class UserRepository extends AbstractEntityManager
{

    public function createUser(string $pseudo, string $email, string $password): void
    {

        $userSql = "INSERT INTO users (pseudo, email, password, avatar, creation_date) VALUES (:pseudo, :email, :password, :avatar, :date)";

        $this->db->query($userSql, [
            'pseudo' => $pseudo,
            'email' => $email,
            'password' => $password,
            'avatar' => 'default_user.png',
            'date' => date('Y-m-d')
        ]);

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

    public function updateUser(int $id, string $newPseudo, string $newEmail, ?string $newPassword = null): void
    {

        $updateUser = <<<EOD
                UPDATE users
                SET pseudo = '$newPseudo',
                email = '$newEmail',
                password = '$newPassword'
                WHERE id = '$id';
                EOD;
        $this->db->query($updateUser);

        $_SESSION['user'] = [
            'id' => $id,
            'email' => $newEmail,
            'pseudo' => $newPseudo,
        ];

    }

    public function getCurrentPasswordByEmail(string $email): ?string
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
        $errors = Utils::checkImage($_FILES);

        if ($errors === null){
            if ($_FILES['picture']['type'] === 'image/jpeg' || $_FILES['picture']['type'] === 'image/jpg') {
                $type = '.jpeg';
            } else {
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
        }
        return null;
    }

    public function getUserById(int $id): ?User
    {
        $query = <<<EOD
                SELECT *
                FROM users
                where id = $id;
                EOD;

        $result = $this->db->query($query)->fetch();

        if ($result !== null){
            $user = new User();
            $user->setId($result['id']);
            $user->setPseudo($result['pseudo']);
            $user->setAvatar($result['avatar']);
            $user->setEmail($result['email']);
            $user->setCreationDate($result['creation_date']);
            return $user;
        }

        return null;


    }

}