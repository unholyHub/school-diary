<?php

if (!isset($loggedUser)) {
    return;
}

require_once './app/controllers/ClassController.php';

use App\Controllers\ClassController;

require_once './app/views/ClassView.php';

use App\Views\ClassView;

$classController = new ClassController($db);
$classView = new ClassView();

$classes = array();

if (isset($_POST['searchterm'])) {
    $subjects = $classController->search($_POST['searchterm']);
} else {
    $subjects = $classController->getAll();
}

if (isset($_GET['del'])) {
    $id = $_GET['del'];
    $classController->delete($id);
    header("Location: index.php?p=class-management");
}

$classView->renderSearchBox();
$classView->renderClassesTable($subjects);
