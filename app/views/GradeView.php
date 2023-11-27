<?php

namespace App\Views;

use App\Constants\GradeTerm;
use App\Constants\GradeType;
use App\Models\GradeModel;

class GradeView extends BaseView
{
    public function renderAddGradeButton($class_id, $user_id)
    {
?>
        <section class="user-form">
            <a class="submit-button submit-button-main" href="index.php?p=grades-page&class_id=<?= $class_id ?>&student_id=<?= $user_id ?>">
                Добави оценка
            </a>
        </section>
    <?php
    }

    public function renderGradeForm(GradeModel $grade, $subjects)
    {
        $gradeToShow = $grade->getGrade() ??  $grade->getFinalGrade();
        $this->renderBack();
    ?>
        <section class="data-form">
            <form action="index.php?p=grades-page" method="post">
                <input type="hidden" name="user_id" value="<?= $grade->getUserId() ?>">
                <input type="hidden" name="class_id" value="<?= $_GET['class_id'] ?>">
                <input type="hidden" name="grade_id" value="<?= $grade->getId() ?>">


                <label for="subject_id">Предмети:</label>
                <select id="subject_id" name="subject_id" required>
                    <option value disabled selected>Избери предмет</option>
                    <?php foreach ($subjects as $subject) { ?>
                        <option value="<?= $subject->getId() ?>" <?= $subject->getId() == $grade->getSubjectId() ? "selected" : "" ?>>
                            <?= $subject->getName() ?>
                        </option>
                    <?php } ?>
                </select>

                <label for="grade_term">Срок:</label>
                <select id="grade_term" name="grade_term" required>
                    <option value disabled selected>Изберете срок...</option>
                    <option value="1" <?= $grade->getTerm() == GradeTerm::FIRST ? "selected" : "" ?>>Първи</option>
                    <option value="2" <?= $grade->getTerm() == GradeTerm::SECOND ? "selected" : "" ?>>Втори</option>
                    <option value="3" <?= $grade->getTerm() == GradeTerm::FINAL ? "selected" : "" ?>>Годишна</option>
                </select>


                <label for="grade_type" id="grade_type_label" <?php
                                                                if ($grade->getTerm() == GradeTerm::FINAL) {
                                                                    echo ' style="display: none"';
                                                                }
                                                                ?>>Тип оценка:</label>
                <select id="grade_type" name="grade_type" <?php
                                                            if ($grade->getTerm() == GradeTerm::FINAL) {
                                                                echo 'required', ' style="display: none"';
                                                            }
                                                            ?>>
                    <option value disabled selected>Изберете тип...</option>
                    <option value="1" <?= $grade->getGrade() !== null ? "selected" : "" ?>>Текуща</option>
                    <option value="2" <?= $grade->getFinalGrade() !== null ? "selected" : "" ?>>Срочна</option>
                </select>

                <label for="grade">Оценка:</label>
                <select id="grade" name="grade" required>
                    <option value disabled selected>Изберете оценка</option>
                    <option value="2" <?= $gradeToShow == 2 ? "selected" : "" ?>>Слаб (2)</option>
                    <option value="3" <?= $gradeToShow == 3 ? "selected" : "" ?>>Среден (3)</option>
                    <option value="4" <?= $gradeToShow == 4 ? "selected" : "" ?>>Добър (4)</option>
                    <option value="5" <?= $gradeToShow == 5 ? "selected" : "" ?>>Много добър (5)</option>
                    <option value="6" <?= $gradeToShow == 6 ? "selected" : "" ?>>Отличен (6)</option>
                </select>

                <button type="submit" class="submit-button submit-button-main">
                    <?php
                    if ($grade->getId() == null) {
                        echo "Добави оценка";
                    } else {
                        echo "Редактирай оценка";
                    }
                    ?>
                </button>
            </form>
        </section>
    <?php
    }

    public function renderGradeDetails(GradeModel $grade)
    {
    ?>
        <section class="grade-details">
            <h2>Grade Details</h2>
            <p>User ID: <?= $grade->getUserId() ?></p>
            <p>Subject ID: <?= $grade->getSubjectId() ?></p>
            <p>Grade: <?= $grade->getGrade() ?></p>
            <p>Final Grade: <?= $grade->getFinalGrade() ?></p>
            <p>Term: <?= $grade->getTerm() ?></p>
        </section>
    <?php
    }

    public function renderSubjectGradesTableForStudent($grades)
    {
    ?>
        <section>
            <h2>Списък с оценки:</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th colspan="2">Първи срок</th>
                        <th colspan="2">Втори срок</th>
                        <th rowspan="2">Годишна</th>
                    </tr>
                    <tr>
                        <th>Текуща</th>
                        <th>Срочна</th>

                        <th>Текуща</th>
                        <th>Срочна</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php

                        foreach ($grades as $term => $value) {
                            if ($term != GradeTerm::FINAL) {
                                echo "<td>";

                                $currentGrades = $value[GradeType::CURRENT] ?? [];
                                foreach ($currentGrades as $g) {
                                    echo $g->getGrade(), " ";
                                }

                                echo "</td>";

                                echo "<td>";
                                echo $value[GradeType::FINAL]->getFinalGrade();
                                echo "</td>";
                            } else {
                                echo "<td>";
                                echo $value->getFinalGrade();
                                echo "</td>";
                            }
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
        </section>
    <?php
    }


    public function renderSubjectGradesTable($grades, $class_id)
    {
    ?>
        <section>
            <h2>Списък с оценки:</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th colspan="2">Първи срок</th>
                        <th colspan="2">Втори срок</th>
                        <th rowspan="2">Годишна</th>
                    </tr>
                    <tr>
                        <th>Текуща</th>
                        <th>Срочна</th>

                        <th>Текуща</th>
                        <th>Срочна</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php

                        foreach ($grades as $term => $value) {
                            if ($term != GradeTerm::FINAL) {
                                echo "<td>";

                                $currentGrades = $value[GradeType::CURRENT] ?? [];
                                foreach ($currentGrades as $g) {
                                    $this->renderGradeLink($g, $class_id);
                                }

                                echo "</td>";

                                echo "<td>";
                                $finalGrade = $value[GradeType::FINAL] ?? null;
                                $this->renderGradeLink($finalGrade, $class_id);
                                echo "</td>";
                            } else {
                                echo "<td>";
                                $this->renderGradeLink($value, $class_id);
                                echo "</td>";
                            }
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
        </section>
    <?php
    }

    private function renderGradeLink(GradeModel $grade, $class_id)
    {
        $gradeToShow = $grade->getGrade() ??  $grade->getFinalGrade();
    ?>
        <a href="index.php?p=grades-page&class_id=<?= $class_id ?>&student_id=<?= $grade->getSubjectId() ?>&grade_id=<?= $grade->getId() ?>"><?= $gradeToShow ?></a>
<?php
    }
}
