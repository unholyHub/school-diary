<?php

if (!isset($loggedUser)) {
    return;
}

require_once './app/controllers/ClassController.php';

use App\Controllers\ClassController;

require_once './app/views/ClassView.php';

use App\Views\ClassView;
use App\Models\ClassModel;

$classController = new ClassController($db);
$selectedClass = new ClassModel();

$url = "index.php?p=class-page&";

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $selectedClass = $classController->get($id);
    $url .= "edit=" . $id;
}

if (isset($_POST["class_number"])) {
    $url = "index.php?p=class-management";

    $class_id = isset($_POST["class_id"]) ? $_POST["class_id"] : null;
    $classNumber = $_POST["class_number"];
    $classChar = $_POST["class_char"];

    $submittedClass = new ClassModel();
    $submittedClass->setId($class_id);
    $submittedClass->setClassNumber($classNumber);
    $submittedClass->setClassChar($classChar);

    $classExists = $classController->existsByClassName($submittedClass);

    if ($classExists) {
        $url = "index.php?p=class-page&e&edit=". $class_id;
        session_write_close();
        header("Location: " . $url);
        exit();
    }

    if ($class_id != null) {
        $classController->modify($submittedClass);
    }

    if ($class_id == null) {
        $result = $classController->create($submittedClass);
    }

    session_write_close();
    header("Location: " . $url);
    exit();
}

$classView = new ClassView();
$classView->renderClassForm($url, $selectedClass);
