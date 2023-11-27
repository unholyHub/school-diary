<?php

if (!isset($loggedUser)) {
    return;
}

use App\Views\UserView;

require_once './app/controllers/UserController.php';
require_once './app/views/UserView.php';

$userController = new UserController($db);
$userView = new UserView();
$foundUsers = array();

if (isset($_POST['searchterm'])) {
    $foundUsers = $userController->searchForUsers($_POST['searchterm']);
} else {
    $foundUsers = $userController->getAllUsers();
}

// delete by id
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    // echo "delete all user-id: ", $id;
    $userController->delete($id);
    header("Location: index.php?p=user-management");
}

$url = "index.php?p=user-management";

$userView->renderSearchBox($url);
$userView->renderFoundUsers($foundUsers);
