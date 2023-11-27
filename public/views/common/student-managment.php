<?php

use App\Views\UserView;
use App\Constants\AccessLevel;

if (!isset($loggedUser) || $loggedUser->getRole() == AccessLevel::STUDENT) {
    return;
}

require_once './app/controllers/UserController.php';
require_once './app/views/UserView.php';

$userController = new UserController($db);
$userView = new UserView();
$url = "?p=home";
$foundUsers = array();

if (isset($_POST['searchterm'])) {
    $foundUsers = $userController->searchByAccessLevel($_POST['searchterm'], AccessLevel::STUDENT);
} else {
    $foundUsers = $userController->getAllByAccessLevel(AccessLevel::STUDENT);
}

$userView->renderSearchBox($url);
$userView->renderFoundUsersForFullInfo($foundUsers);
