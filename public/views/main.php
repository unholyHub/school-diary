<?php

use App\Helpers\JavaScriptManager;
use Config\Database;

require_once './config/Database.php';

require_once './app/views/BaseView.php';

require_once './app/helpers/DateTimeHelper.php';
require_once './app/helpers/JavaSriptManager.php';

require_once './app/constants/AccessLevel.php';
require_once './app/constants/AbsenseType.php';

require_once './app/constants/GradeTerm.php';
require_once './app/constants/GradeType.php';

require_once './app/constants/DayOfWeek.php';

require_once './app/constants/SubjectType.php';

JavaScriptManager::addScript("script.js");
$db = new Database();

$page = isset($_GET['p']) ? $_GET['p'] : "";

$api = isset($_GET['api']) ? $_GET['api'] : "";

$viewsPath = './api/';
if ($api == "get-classes-for-subject") {
    include_once $viewsPath . 'get-classes-for-subject.php';
    exit();
}

include_once 'header.php';

// Define the base path to the views folder
$viewsPath = './public/views/admin/';

// USERS - START
if ($page == "user-management") {
    include_once $viewsPath . 'user-management.php';
}

if ($page == "user-page") {
    include_once $viewsPath . 'user-page.php';
}

if ($page == "user-class") {
    include_once $viewsPath . 'user-class.php';
}

if ($page == "user-subjects") {
    include_once $viewsPath . 'user-subjects.php';
}
// USERS - END

// SUBJECTS - START
if ($page == "subject-management") {
    include_once $viewsPath . 'subject-management.php';
}

if ($page == "subject-page") {
    include_once $viewsPath . 'subject-page.php';
}
// SUBJECTS - END

// CLASSES - START
if ($page == "class-management") {
    include_once $viewsPath . 'class-management.php';
}

if ($page == "class-page") {
    include_once $viewsPath . 'class-page.php';
}
// CLASSES - START

$viewsPath = './public/views/common/';
if ($page == "subject-personal") {
    include_once $viewsPath . 'subject-personal.php';
}
// TEACHERS - START
$viewsPath = './public/views/teacher/';
if ($page == "subject-schedule") {
    include_once $viewsPath . 'subject-schedule.php';
}

if ($page == "subject-schedule-info") {
    include_once $viewsPath . 'subject-schedule-info.php';
}

if ($page == "message-management") {
    include_once $viewsPath . 'message-management.php';
}

if ($page == "message-page") {
    include_once $viewsPath . 'message-page.php';
}

if ($page == "schedule-management") {
    include_once $viewsPath . 'schedule-managment.php';
}

if ($page == "schedule-add") {
    include_once $viewsPath . 'schedule-add.php';
}

if ($page == "subject-topic-management") {
    include_once $viewsPath . 'subject-topic-management.php';
}

if ($page == "subject-topic-add") {
    include_once $viewsPath . 'subject-topic-add.php';
}

if ($page == "inclass-management") {
    include_once $viewsPath . 'inclass-management.php';
}

if ($page == "inclass-page") {
    include_once $viewsPath . 'inclass-page.php';
}

if ($page == "grades-management") {
    include_once $viewsPath . 'grades-management.php';
}

if ($page == "grades-page") {
    include_once $viewsPath . 'grades-page.php';
}

if ($page == "absences-management") {
    include_once $viewsPath . 'absences-management.php';
}

if ($page == "absences-page") {
    include_once $viewsPath . 'absences-page.php';
}

$viewsPath = './public/views/common/';
if ($page == "home") {
    include_once $viewsPath . 'student-managment.php';
}

if ($page == "student-page") {
    include_once $viewsPath . 'student-page.php';
}

// TEACHERS - END

include_once 'footer.php';
