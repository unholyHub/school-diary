<?php

use App\Constants\AccessLevel;
if (!isset($loggedUser) || $loggedUser->getRole() != AccessLevel::TEACHER) {    
    return;
}

use App\Views\UserView;

require_once './app/controllers/UserController.php';
require_once './app/views/UserView.php';

$userController = new UserController($db);
$userView = new UserView();
$url = "?p=message-management";
$foundUsers = array();

if (isset($_POST['searchterm'])) {
    $foundUsers = $userController->searchByAccessLevel($_POST['searchterm'], AccessLevel::STUDENT);
} else {
    $foundUsers = $userController->getAllByAccessLevel(AccessLevel::STUDENT);
}

$userView->renderSearchBox($url);
$userView->renderFoundUsersForMessages($foundUsers);
