<?php

namespace App\Models\Repositories;

use App\Models\UserModel;

use Config\Database;
use PDO;

class UserRepository
{
    private $db;

    private $dbObject;

    private $table_name = "users";

    public function __construct(Database $db)
    {
        $this->dbObject = $db;
        $this->db = $db->getConnection();
    }

    public function createStudent(UserModel $user)
    {
        $sql = "
        INSERT INTO "
            . $this->table_name . " 
            (username, password, first_name, last_name, phone_number, parent_email, profile_picture)
        VALUES (
            :username, 
            :password, 
            :firstName, 
            :lastName, 
            :phoneNumber, 
            :parentEmail,
            :profile_picture)";

        $stmt = $this->db->prepare($sql);

        $username = $user->getUsername();
        $password = $user->getPassword();
        $firstName = $user->getFirstName();
        $lastName = $user->getLastName();
        $phoneNumber = $user->getPhoneNumber();
        $parentEmail = $user->getParentEmail();
        $profilePicture = $user->getProfilePicture();

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':phoneNumber', $phoneNumber);
        $stmt->bindParam(':parentEmail', $parentEmail);
        $stmt->bindParam(':profile_picture', $profilePicture);

        if ($stmt->execute()) {
            return $this->db->lastInsertId();
        } else {
            return -1;
        }
    }


    public function login($username, $password)
    {
        $sql = "
            SELECT 
                u.*,
                role_id
            FROM 
                " . $this->table_name . "  AS u
            INNER JOIN 
                user_roles AS ar
            ON
                u.id = ar.user_id
            WHERE
                username = :username";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $password == $result["password"]) {
            return $result;
        } else {
            // Login failed
            return false;
        }
    }

    public function checkUsernameExists($username)
    {
        $sql = "
            SELECT 
                COUNT(*) as count 
            FROM "
            . $this->table_name . " 
            WHERE 
                username = :username";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['count'] > 0;
    }

    public function getAllUsers()
    {
        $users = array();

        $query = "
        SELECT
            u.*,
            ur.role_id,
            c.id AS class_id,
            CONCAT(c.number, c.div_char) AS class_name
        FROM
            users AS u
            INNER JOIN user_roles AS ur ON u.id = ur.user_id
            LEFT JOIN user_classes AS uc on uc.user_id = u.id
            LEFT JOIN classes c on uc.class_id = c.id";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row) {
            $user = new UserModel();
            $user->setId($row['id']);
            $user->setFirstName($row['first_name']);
            $user->setLastName($row['last_name']);

            $user->setClassId($row['class_id']);
            $user->setClass($row['class_name']);
            $user->setPhoneNumber($row['phone_number']);
            $user->setProfilePicture($row['profile_picture']);

            $user->setRole($row['role_id']);

            $users[] = $user;
        }

        return $users;
    }

    public function searchForUsers($searchTerm)
    {
        $searchTerm = trim(str_replace(' ', '', $searchTerm));

        $users = array();

        $query = "SELECT
                    u.id AS user_id,
                    u.*,
                    ar.role_id,
                    uc.id AS class_id,
                    CONCAT(c.number, c.div_char) AS class_name
                FROM
                    users AS u
                    INNER JOIN user_roles AS ar ON u.id = ar.user_id
                    LEFT JOIN user_classes AS uc on uc.user_id = u.id
                    LEFT JOIN classes AS c ON c.id = uc.class_id
                WHERE
                    CONCAT_WS(
                        '',
                        username,
                        password,
                        first_name,
                        last_name,
                        phone_number,
                        parent_email
                    ) LIKE :searchTerm";

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':searchTerm', '%' . $searchTerm . '%');
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row) {
            $user = new UserModel();
            $user->setId($row['user_id']);
            $user->setUsername($row['username']);
            $user->setPassword($row['password']);
            $user->setFirstName($row['first_name']);
            $user->setLastName($row['last_name']);
            $user->setPhoneNumber($row['phone_number']);
            $user->setParentEmail($row['parent_email']);
            $user->setRole($row['role_id']);

            $user->setClassId($row['class_id']);
            $user->setClass($row['class_name']);

            $users[] = $user;
        }

        return $users;
    }

    public function getUserById($userId)
    {
        $query = "SELECT * FROM users  AS u
        INNER JOIN 
            user_roles AS ar
        ON
            u.id = ar.user_id WHERE u.id = :userId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return new UserModel();
        }

        $user = new UserModel();
        $user->setId($result['user_id']);
        $user->setUsername($result['username']);
        $user->setPassword($result['password']);
        $user->setFirstName($result['first_name']);
        $user->setLastName($result['last_name']);
        //$user->setClassId($result['class_id']);
        $user->setPhoneNumber($result['phone_number']);
        $user->setParentEmail($result['parent_email']);
        //$user->setUserId($result['user_id']);
        $user->setRole($result['role_id']);
        $user->setProfilePicture($result['profile_picture']);

        return $user;
    }

    public function modifyUser(UserModel $user)
    {
        // Get user data from the UserModel object
        $username = $user->getUsername();
        $password = $user->getPassword();
        $firstName = $user->getFirstName();
        $lastName = $user->getLastName();
        $phoneNumber = $user->getPhoneNumber();
        $parentEmail = $user->getParentEmail();
        $profilePicture = $user->getProfilePicture();
        $user_id = (int)$user->getId();

        $sql = "UPDATE users 
            SET username = :username,
                password = :password,
                first_name = :firstName,
                last_name = :lastName,
                phone_number = :phoneNumber,
                parent_email = :parentEmail";

        // Add profile_picture to the SQL query only if it is not null
        if ($profilePicture !== null) {
            $sql .= ", profile_picture = :profilePicture";
        }

        $sql .= " WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        // Bind all other parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':phoneNumber', $phoneNumber);
        $stmt->bindParam(':parentEmail', $parentEmail);

        // Bind profile_picture only if it is not null
        if ($profilePicture !== null) {
            $stmt->bindParam(':profilePicture', $profilePicture);
        }

        $stmt->bindParam(':id', $user_id);
        return $stmt->execute();
    }

    public function delete($userId)
    {
        $sql = "DELETE FROM users WHERE id = :userId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getAllByAccessLevel(int $accessLevel): array
    {
        $sql = "SELECT 
        u.id AS id,
        u.first_name, u.last_name, 
        CONCAT(c.number,c.div_char) AS class_name 
        FROM users u 
        INNER JOIN user_roles ua ON u.id = ua.user_id 
        INNER JOIN user_classes uc ON u.id = uc.user_id 
        INNER JOIN classes c ON c.id = uc.class_id 
        WHERE ua.role_id = :accessLevel
        ORDER BY c.number, c.div_char";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':accessLevel', $accessLevel, \PDO::PARAM_INT);
        $stmt->execute();

        $users = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new UserModel();
            $user->setId($row['id']);
            $user->setFirstName($row['first_name']);
            $user->setLastName($row['last_name']);
            $user->setClass($row['class_name']);

            $users[] = $user;
        }

        return $users;
    }

    public function searchUsersByAccessLevel(string $searchTerm, $accessLevel): array
    {
        $searchTerm = str_replace(' ', '', $searchTerm);
        $searchTerm = '%' . $searchTerm . '%';

        $sql = "SELECT 
        u.id AS id,
        u.first_name, u.last_name, 
        CONCAT(c.number,c.div_char) AS class_name 
        FROM users u 
        INNER JOIN user_roles ua ON u.id = ua.user_id 

        INNER JOIN user_classes uc ON u.id = uc.user_id 
        INNER JOIN classes c ON c.id = uc.class_id 
        WHERE CONCAT(username, password, first_name, last_name) LIKE :searchTerm AND role_id = :accessLevel
        ORDER BY c.number, c.div_char";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':searchTerm', $searchTerm, \PDO::PARAM_STR);
        $stmt->bindParam(':accessLevel', $accessLevel, \PDO::PARAM_INT);
        $stmt->execute();

        $users = [];

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $user = new UserModel();
            $user->setId($row['id']);
            $user->setFirstName($row['first_name']);
            $user->setLastName($row['last_name']);
            $user->setClass($row['class_name']);

            $users[] = $user;
        }

        return $users;
    }
}
