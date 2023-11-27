<nav>
    <ul class="menu">

        <!-- All -->
        <li>
            <a href="./index.php?p=home">Начало</a>
        </li>

        <!-- Admin -->
        <?php

        use App\Constants\AccessLevel;

        if (isset($loggedUser) && $loggedUser->getRole() === AccessLevel::ADMIN) { ?>
            <li><a href="?p=subject-management">Предмети/Клубове</a></li>
            <li><a href="?p=class-management">Класове</a></li>
            <li><a href="?p=user-management">Потребители</a></li>
        <?php } ?>

        <!-- Teacher -->
        <?php if (isset($loggedUser) && $loggedUser->getRole() === AccessLevel::TEACHER) { ?>
            <li><a href="?p=inclass-management">В час</a></li>
            <li><a href="?p=schedule-management">Разписание</a></li>
            <li><a href="?p=message-management">Съобщения</a></li>
            <li><a href="?p=subject-personal">Мои предмети</a></li>
        <?php } ?>

        <!-- Student -->
        <?php if (isset($loggedUser) && $loggedUser->getRole() === AccessLevel::STUDENT) { ?>
            <li><a href="?p=grades-management">Мои оценки</a></li>
            <li><a href="?p=absences-management">Мои Отсъствия</a></li>
            <li><a href="?p=subject-personal">Мои предмети</a></li>
            <li><a href="?p=message-page">Съобщения</a></li>
            <li><a href="?p=user-page">Профил</a></li>
        <?php } ?>
    </ul>
</nav>