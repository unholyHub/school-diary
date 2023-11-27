<?php

namespace App\Models;

class UserModel
{
    private $id = null;

    private $username;
    private $password;

    private $role;

    private $firstName;
    private $lastName;

    private $phoneNumber;

    private $parentEmail;

    private $profilePicture;

    private $class;
    private $classId;

    private $userTypes = [
        1 => 'администратор',
        2 => 'учител',
        3 => 'ученик'
    ];

    // Setters and getters for the properties

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getRole(): int
    {
        if ($this->role == null) {
            return -1;
        }

        return $this->role;
    }

    public function getRoleName()
    {
        return $this->userTypes[$this->role];
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getFullName()
    {
        return $this->firstName . " " . $this->lastName;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getparentEmail()
    {
        return $this->parentEmail;
    }

    public function setparentEmail($parentEmail)
    {
        $this->parentEmail = $parentEmail;
    }

    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    public function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function setClass($class)
    {
        $this->class = $class;
    }

    public function getClassId()
    {
        return $this->classId;
    }

    public function setClassId($classId)
    {
        $this->classId = $classId;
    }

    public static function fromArray($data)
    {
        $user = new UserModel();

        $user->id = isset($data['id']) ? $data['id'] : null;
        $user->username = isset($data['username']) ? $data['username'] : null;
        $user->password = isset($data['password']) ? $data['password'] : null;
        $user->firstName = isset($data['first_name']) ? $data['first_name'] : null;
        $user->lastName = isset($data['last_name']) ? $data['last_name'] : null;
        $user->phoneNumber = isset($data['phone_number']) ? $data['phone_number'] : null;
        $user->parentEmail = isset($data['parent_email']) ? $data['parent_email'] : null;
        $user->role = isset($data['role_id']) ? $data['role_id'] : null;

        return $user;
    }
}
