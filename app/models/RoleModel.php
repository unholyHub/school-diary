<?php

// Role.php

namespace App\Models;

class RoleModel
{
    private $user_id;
    private $role_id;

    public function __construct($user_id, $role_id)
    {
        $this->user_id = $user_id;
        $this->role_id = $role_id;
    }

    // Getters and setters for the properties
    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getRoleId()
    {
        return $this->role_id;
    }

    public function setRoleId($role_id)
    {
        $this->role_id = $role_id;
    }

    // You can also add other methods as needed, e.g., for validation, data manipulation, etc.
}
