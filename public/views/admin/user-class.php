<?php

require_once './app/controllers/UserController.php';
require_once './app/controllers/ClassController.php';

require_once './app/views/ClassView.php';
require_once './app/views/UserView.php';

use App\Controllers\ClassController;

use App\Views\ClassView;
use App\Views\UserView;

$userController = new UserController($db);
$classController = new ClassController($db);
$userView = new UserView();
$classView = new ClassView();

$user_id = $_GET['user_id'];
$url = "index.php?p=user-class&user_id=" . $user_id;

if (isset($_POST['select_class'])) {
    $class_id = $_POST['select_class'];
    $user_id = $_POST['user_id'];
    $classController->addUserToClass($class_id, $user_id);

    session_write_close();
    header("Location: index.php?p=user-management");
    exit();
}

$studentClass = $classController->getClassByUserId($user_id);

$student = $userController->getUserById($user_id);
$student->setClassId($studentClass->getId());

$classes = array();
if ($studentClass->getId() == null) {
    $classes = $classController->getAll();
} else {
    $classes = $classController->getAllForStudentModification($student->getId());
}

$classView->renderStudentData($student);
$classView->renderStudentClassForm($url, $classes, $student);
