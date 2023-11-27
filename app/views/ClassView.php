<?php

namespace App\Views;

use App\Models\ClassModel;
use App\Models\UserModel;

class ClassView extends BaseView
{

    public function renderTitle(ClassModel $class)
    {
        $this->renderBack();

?>
        <section class="user-form">
            <h1>
                Клас: <?= $class->getFullClassName() ?>
            </h1>
        </section>
    <?php
    }

    public function renderSearchBox()
    {
    ?>
        <section class="user-form">
            <form method="POST" action="index.php?p=class-management">
                <label for="searchterm">Търси клас:</label>
                <input type="text" name="searchterm" id="searchterm" placeholder="Въведете поле за търсене" <?php
                                                                                                            if (isset($_POST["searchterm"])) {
                                                                                                                echo 'value="', $_POST["searchterm"], '"';
                                                                                                            }
                                                                                                            ?> required>
                <button class="submit-button submit-button-main">Търси</button>
            </form>

            <a class="submit-button submit-button-main" href="index.php?p=class-page">
                Добави клас
            </a>
        </section>
    <?php
    }

    public function renderClassesTable($classes)
    {
        $count = 1;
    ?>
        <table class="table">
            <thead>
                <tr>
                    <th>№</th>
                    <th>Клас</th>
                    <th>Паралелка</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($classes as $class) { ?>
                    <tr>
                        <td><?= $count++; ?></td>
                        <td><?= $class->getClassNumber(); ?></td>
                        <td><?= $class->getClassChar(); ?></td>
                        <td>
                            <a href="index.php?p=class-page&edit=<?= $class->getId(); ?>">Редактирай</a>
                            <br>
                            <a href="index.php?p=class-management&del=<?= $class->getId(); ?>">Изтрий</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php
    }

    public function renderStudentData(UserModel $student)
    {
    ?>
        <section class="data-form">
            <div>Ученик:</div>
            <div><strong><?php
                            echo
                            $student->getFirstName(), " ",
                            $student->getLastName()
                            ?>
                </strong></div>
        </section>

    <?php
    }

    public function renderStudentClassForm($url, $classes, UserModel $student)
    {
        $this->renderBack();
    ?>
        <section class="data-form">
            <form action="<?= $url ?>" method="post">
                <?php if ($student->getId() !== null) { ?>
                    <input type="hidden" name="user_id" value="<?= $student->getId(); ?>">
                <?php } ?>

                <?php if (!empty($classes)) { ?>
                    <label for="select_class">Избери клас:</label>
                    <select id="select_class" name="select_class">
                        <option selected value disabled>Избери...</option>
                        <?php foreach ($classes as $c) {
                            $selected = '';
                            if ($c->getId() === $student->getClassId()) {
                                $selected = 'selected';
                            }
                        ?>
                            <option value="<?= $c->getId(); ?>" <?= $selected ?>>
                                <?= $c->getClassNumber() . $c->getClassChar(); ?>
                            </option>
                        <?php } ?>
                    </select>
                <?php } ?>

                <button type="submit" class="submit-button submit-button-main">
                    <?php if ($student->getId() === null) { ?>
                        Добави
                    <?php } else { ?>
                        Редактирай
                    <?php } ?>
                </button>
            </form>
        </section>
    <?php
    }

    public function renderClassForm($url, ClassModel $class)
    {
        $this->renderBack();
    ?>
        <section class="data-form">
            <form action="<?= $url ?>" method="post">

                <?php if (isset($_GET['e'])) { ?>
                    <p>
                        Класът вече съществува
                    </p>
                <?php } ?>
                <?php if ($class->getId() !== null) { ?>
                    <input type="hidden" name="class_id" value="<?= $class->getId(); ?>">
                <?php } ?>

                <label for="class_number">Клас:</label>
                <input type="number" id="class_number" name="class_number" min="1" max="12" placeholder="1" required value="<?= $class->getClassNumber(); ?>">

                <label for="class_char">Паралелка:</label>
                <select id="class_char" name="class_char" required>
                    <option disabled value selected>Изберете паралелка...</option>
                    <?php

                    $cyrillicChars = 'абвгдежзий'; //клмнопрстуфхцчшщъьюя';
                    for ($i = 0; $i < mb_strlen($cyrillicChars); $i++) {
                        $char = mb_substr($cyrillicChars, $i, 1);
                        $isSelected = $char === $class->getClassChar() ? 'selected' : '';
                        echo '<option value="' . $char . '" ' . $isSelected . '>' . $char . '</option>';
                    }
                    ?>
                </select>

                <button type="submit" class="submit-button submit-button-main">
                    <?php if ($class->getId() === null) { ?>
                        Създай
                    <?php } else { ?>
                        Редактирай
                    <?php } ?>
                </button>
            </form>
        </section>
    <?php
    }

    public function renderClassesForTeacher($classes)
    {
    ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Клас</th>
                    <th>Паралелка</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($classes as $class) { ?>
                    <tr>
                        <td><?= $class->getClassNumber(); ?></td>
                        <td><?= $class->getClassChar(); ?></td>
                        <td>
                            <a href="index.php?p=inclass-page&class_id=<?= $class->getId(); ?>">
                                Влез в час
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php
    }

    public function renderStudentsForClass($class_id, $students)
    {
        $count = 1;
    ?>
        <table class="table">
            <thead>
                <tr>
                    <th>№</th>
                    <th>Име на ученика</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $s) { ?>
                    <tr>
                        <td><?= $count++; ?></td>
                        <td><?= $s->getFullName(); ?></td>
                        <td>
                            <a href="index.php?p=absences-management&class_id=<?= $class_id ?>&student_id=<?= $s->getId() ?>">
                                Впиши отсъствия
                            </a>
                            <br>
                            <a href="index.php?p=grades-management&class_id=<?= $class_id ?>&student_id=<?= $s->getId() ?>">
                                Впиши оценки
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
<?php
    }
}
