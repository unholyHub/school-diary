<?php

// RoleRepository.php

namespace App\Models\Repositories;

use App\Models\RoleModel;
use Config\Database;

class RoleRepository
{
    private $db;
    private $table_name = "user_roles";

    public function __construct(Database $db)
    {
        $this->db = $db->getConnection();
    }

    public function create(RoleModel $role)
    {
        if ($this->hasRole($role->getUserId())) {
            $this->modify($role->getUserId(), $role->getRoleId());
            return true;
        }

        $sql = "INSERT INTO " . $this->table_name . " (user_id, role_id) VALUES (:user_id, :role_id)";

        $stmt = $this->db->prepare($sql);

        $user_id = $role->getUserId();
        $stmt->bindParam(':user_id', $user_id);

        $role_id = $role->getRoleId();
        $stmt->bindParam(':role_id', $role_id);

        return $stmt->execute();
    }

    public function hasRole($user_id)
    {
        $sql = "SELECT COUNT(*) AS count FROM " . $this->table_name . " WHERE user_id = :user_id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        $row = $stmt->fetch();
        $count = $row['count'];

        return ($count > 0);
    }

    public function getRoleByUserId($user_id)
    {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE user_id = :user_id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return new RoleModel($row['user_id'], $row['role_id']);
    }

    public function modify($user_id, $new_role_id)
    {
        $sql = "UPDATE " . $this->table_name . " SET role_id = :role_id WHERE user_id = :user_id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':role_id', $new_role_id);

        return $stmt->execute();
    }
}
