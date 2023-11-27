<?php

require_once './app/models/repositories/RoleRepository.php';

use App\Models\Repositories\RoleRepository;
use App\Models\RoleModel;

require_once './app/models/repositories/UserRepository.php';

use App\Models\Repositories\UserRepository;
use App\Models\UserModel;

require_once './app/models/repositories/SubjectRepository.php';

use App\Models\Repositories\SubjectRepository;

use Config\Database;

class UserController
{
    private $userRepository;

    private $roleRepository;

    private $subjectRepository;

    public function __construct(Database $db)
    {
        $this->userRepository = new UserRepository($db);
        $this->roleRepository = new RoleRepository($db);
        $this->subjectRepository = new SubjectRepository($db);
    }

    public function searchForUsers($searchTerm)
    {
        return $this->userRepository->searchForUsers($searchTerm);
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAllUsers();
    }

    public function getUserById($id)
    {
        return $this->userRepository->getUserById($id);
    }

    public function create(UserModel $newUser)
    {
        $lastId = $this->userRepository->createStudent($newUser);

        if ($lastId == -1) {
            return false;
        }

        $role = new RoleModel($lastId, $newUser->getRole());
        return $this->roleRepository->create($role);
    }

    public function modify(UserModel $submittedUser)
    {
        if (!$this->userRepository->modifyUser($submittedUser)) {
            return false;
        }

        return $this->roleRepository->modify($submittedUser->getId(), $submittedUser->getRole());
    }

    public function delete($id)
    {
        $this->userRepository->delete($id);
    }

    public function login($username, $password)
    {
        return $this->userRepository->login($username, $password);
    }

    public function getAllSubjetsByUserId($user_id)
    {
        return $this->subjectRepository->getAllSubjetsByUserId($user_id);
    }

    public function getAllByAccessLevel($access_level)
    {
        return $this->userRepository->getAllByAccessLevel($access_level);
    }

    public function searchByAccessLevel($searchTerm, $access_level)
    {
        return $this->userRepository->searchUsersByAccessLevel($searchTerm, $access_level);
    }
}
