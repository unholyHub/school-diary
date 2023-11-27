<?php

if (!isset($loggedUser)) {
    return;
}

use App\Constants\AccessLevel;
use App\Models\UserModel;
use App\Views\UserView;

require_once './app/controllers/UserController.php';
require_once './app/views/UserView.php';

//$userRepository = new UserRepository($db);
$userController = new UserController($db);
$selectedUser = new UserModel();

$url = "index.php?p=user-page&";
$id = -1;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $url .= "edit=" . $id;
}

if ($loggedUser->getRole() == AccessLevel::STUDENT) {
    $id = $loggedUser->getId();
}

$selectedUser = $userController->getUserById($id);

if (isset($_POST["username"])) {

    require_once './app/models/repositories/RoleRepository.php';
    require_once './app/models/RoleModel.php';

    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : NULL;
    $submittedUser = new UserModel();
    $submittedUser->setUsername($_POST["username"]);
    $submittedUser->setPassword($_POST["password"]);
    $submittedUser->setFirstName($_POST["first_name"]);
    $submittedUser->setLastName($_POST["last_name"]);
    $submittedUser->setPhoneNumber($_POST["phone_number"]);
    $submittedUser->setParentEmail($_POST["parent_email"] ?? null);
    $submittedUser->setRole($_POST["user_role"]);
    $submittedUser->setId($user_id);

    $targetDirectory = 'uploads/';

    if ($_FILES["profile_picture"]["error"] === UPLOAD_ERR_OK) {
        $originalFileName = basename($_FILES["profile_picture"]["name"]);
        $uniqueFileName = uniqid() . "_" . $originalFileName;
        //$uniqueFileName = $originalFileName;
        $targetFile = $targetDirectory . $uniqueFileName;
        $submittedUser->setProfilePicture($uniqueFileName);

        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile);
    }

    if ($user_id == NULL) {
        //$userRepository->createStudent()
        $result = $userController->create($submittedUser);
        $url = "index.php?p=user-management";
    }

    if ($user_id !== NULL) {
        $userController->modify($submittedUser);
    }

    session_write_close();
    header("Location: " . $url);
    exit;
}

$userView = new UserView();
$userView->renderUserDataForm($url, $selectedUser);
