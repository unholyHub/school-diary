<?php

namespace App\Views;

use App\Constants\SubjectType;
use App\Models\SubjectModel;

class SubjectView extends BaseView
{
    public function __construct()
    {
    }

    public function rednerTitle(SubjectModel $subject)
    {
?>
        <section class="user-form">
            <h2><?php echo $subject->getName(); ?></h2>
        </section>

    <?php
    }

    public function renderSearchBox($url)
    {
    ?>
        <section class="user-form">
            <form method="POST" action="<?= $url ?>">
                <?php
                if (
                    isset($_GET["p"]) &&
                    $_GET["p"] === "user-subjects" &&
                    isset($_GET["user_id"])
                ) {
                    $user_id = $_GET["user_id"];
                    echo '<input type="hidden" name="user_id" value="', $user_id, '">';
                }
                ?>

                <label for="searchterm">Търси предмет/клуб:</label>
                <input type="text" name="searchterm" id="searchterm" placeholder="Въведете поле за търсене" <?php
                                                                                                            if (isset($_POST["searchterm"])) {
                                                                                                                echo 'value="', $_POST["searchterm"], '"';
                                                                                                            }
                                                                                                            ?> required>
                <button class="submit-button submit-button-main">Търси</button>
            </form>

            <?php $this->renderAddSubject() ?>
        </section>
    <?php

    }

    public function renderAddSubject()
    {
    ?>
        <a class="submit-button submit-button-main" href="index.php?p=subject-page">
            Добави предмет/клуб
        </a>
    <?php
    }

    public function renderAddSubjectWithSection()
    {
    ?>
        <section class="data-form">
            <a class="submit-button submit-button-main" href="index.php?p=user-subjects">
                Добави предмет/клуб
            </a>
        </section>
    <?php
    }

    public function renderAllSubjectsTableForTeacher(array $classes, $user_id)
    {
    ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Име</th>
                    <th>Учи се от</th>
                    <th>Учи се до</th>
                    <th>Тип</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($classes as $class) { ?>
                    <tr>
                        <td><?php echo $class->getName(); ?></td>
                        <td><?php echo $class->getMinStartingGrade(); ?> клас</td>
                        <td><?php echo $class->getMaxEndingGrade(); ?> клас</td>
                        <td>
                            <?php

                            if ($class->getIsMain() == SubjectType::MAIN) {
                                echo "Основен";
                            } else {
                                echo "Клуб по интереси";
                            }
                            ?>
                        </td>

                        <td>
                            <a href="index.php?p=subject-topic-management&user_id=<?= $user_id ?>&subject_id=<?= $class->getId() ?>">
                                Тематично разпределение
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php
    }

    public function renderAllSubjectsTableForStudent(array $classes)
    {
    ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Име</th>
                    <th>Учи се от</th>
                    <th>Учи се до</th>
                    <th>Тип</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($classes as $class) { ?>
                    <tr>
                        <td><?php echo $class->getName(); ?></td>
                        <td><?php echo $class->getMinStartingGrade(); ?> клас</td>
                        <td><?php echo $class->getMaxEndingGrade(); ?> клас</td>
                        <td>
                            <?php

                            if ($class->getIsMain() == SubjectType::MAIN) {
                                echo "Основен";
                            } else {
                                echo "Клуб по интереси";
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php
    }

    public function renderAllSubjectsTable(array $classes, $select = false)
    {
        $count = 1;
    ?>
        <table class="table">
            <thead>
                <tr>
                    <th>№</th>
                    <th>Име</th>
                    <th>Учи се от</th>
                    <th>Учи се до</th>
                    <th>Тип</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($classes as $class) { ?>
                    <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo $class->getName(); ?></td>
                        <td><?php echo $class->getMinStartingGrade(); ?> клас</td>
                        <td><?php echo $class->getMaxEndingGrade(); ?> клас</td>
                        <td>
                            <?php

                            if ($class->getIsMain() == SubjectType::MAIN) {
                                echo "Основен";
                            } else {
                                echo "Клуб по интереси";
                            }
                            ?>
                        </td>

                        <td>
                            <?php
                            if ($select) {
                                $this->renderSelectSubject($class->getId());
                            } else {
                                $this->renderEditDeleteLinks($class->getId());
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php
    }

    public function renderSubjectForm($url, SubjectModel $subject)
    {
        $this->renderBack();
    ?>

        <section class="data-form">
            <form action="<?= $url ?>" method="post">
                <?php if (isset($_GET['d'])) { ?>
                    <p>
                        Не може класът на започване да е по-голям.
                    </p>
                <?php } ?>

                <?php if ($subject->getName() !== null) { ?>
                    <input type="hidden" name="subject_id" value="<?= $subject->getId() ?>">
                <?php } ?>

                <label for="subject_name">Име на предмета:</label>
                <input type="text" id="subject_name" name="subject_name" value="<?= $subject->getName() ?>" required>

                <label for="min_starting_grade">Изучава се от:</label>
                <select id="min_starting_grade" name="min_starting_grade" required>
                    <option selected value disabled>Избери...</option>
                    <?php
                    for ($grade = 1; $grade <= 12; $grade++) {
                        $isSelected = "";
                        if ($grade == $subject->getMinStartingGrade()) {
                            $isSelected = "selected";
                        }

                        echo '<option value="' . $grade . '" ', $isSelected, ' >' . $grade . ' клас</option>';
                    }
                    ?>
                </select>

                <label for="max_ending_grade">До клас:</label>
                <select id="max_ending_grade" name="max_ending_grade" required>
                    <option selected value disabled>Избери...</option>
                    <?php
                    for ($grade = 1; $grade <= 12; $grade++) {
                        $isSelected = "";
                        if ($grade == $subject->getMaxEndingGrade()) {
                            $isSelected = "selected";
                        }

                        echo '<option value="' . $grade . '" ', $isSelected, ' >' . $grade . ' клас</option>';
                    }
                    ?>
                </select>

                <label for="is_main">Занимание:</label>
                <select id="is_main" name="is_main">
                    <option value="1" <?php if ($subject->getIsMain() == SubjectType::MAIN) echo 'selected'; ?>>Основен</option>
                    <option value="2" <?php if ($subject->getIsMain() == SubjectType::INTEREST_CLUB) echo 'selected'; ?>>Клуб по интереси</option>
                </select>

                <button type="submit" class="submit-button submit-button-main">
                    <?php if ($subject->getName() == null) { ?>
                        Добави предмет
                    <?php } else { ?>
                        Редактирай
                    <?php } ?>
                </button>
            </form>

        <?php
    }

    private function renderEditDeleteLinks($subjectId)
    {
        ?>
            <a href="index.php?p=subject-page&edit=<?php echo $subjectId; ?>">Редактирай</a>
            <br>
            <a href="index.php?p=subject-management&del=<?php echo $subjectId; ?>">Изтрий</a>
        <?php
    }

    private function renderSelectSubject($subjectId)
    {
        $isset = isset($_GET['user_id']);
        $user_id = $isset ? $_GET['user_id'] : "";
        $linkText = $isset ? "Избери за учител" : "Избери";

        ?>
            <a href="index.php?p=user-subjects&user_id=<?= $user_id ?>&subject_id=<?php echo $subjectId; ?>">
                <?= $linkText ?>
            </a>
    <?php
    }
}
