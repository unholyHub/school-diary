<?php

namespace App\Views;

use App\Constants\AbsenseType;
use App\Helpers\DateTimeHelper;
use App\Models\AbsenceModel;

class AbsenceView extends BaseView
{
    public function renderAddButton(AbsenceModel $absence)
    {
?>
        <section class="user-form">
            <a class="submit-button submit-button-main" href="index.php?p=absences-page&student_id=<?= $absence->getUserId() ?>&class_id=<?= $absence->getClassId() ?>">
                Добави отсъствие
            </a>
        </section>
    <?php
    }

    public function renderAddForm(AbsenceModel $absence, $subjects)
    {
        $date =  $absence->getCreatedOn() ?? DateTimeHelper::getTimeISO();
        $url = "index.php?p=absences-page&class_id={$absence->getClassId()}&student_id={$absence->getUserId()}";
        $this->renderBack();
    ?>
        <section class="data-form">
            <form action="<?= $url ?>" method="post">
                <input type="hidden" id="user_id" name="user_id" value="<?= $absence->getUserId() ?>">
                <input type="hidden" id="class_id" name="class_id" value="<?= $absence->getClassId() ?>">

                <?php if ($absence->getId() != null) { ?>
                    <input type="hidden" id="absence_id" name="absence_id" value="<?= $absence->getId() ?>">
                <?php } ?>

                <label for="subject_id">Предмети:</label>
                <select id="subject_id" name="subject_id" required>
                    <option value disabled selected>Избери предмет</option>
                    <?php foreach ($subjects as $subject) { ?>
                        <option value="<?= $subject->getId() ?>" <?= $subject->getId() == $absence->getSubjectId() ? "selected" : "" ?>>
                            <?= $subject->getName() ?>
                        </option>
                    <?php } ?>
                </select>

                <label for="is_full">Тип отсъствие:</label>
                <select id="is_full" name="is_full" required>
                    <option value disabled selected>Изберете опция</option>
                    <option value="0" <?= $absence->getIsFull() == AbsenseType::PARTIAL ? "selected" : "" ?>>Частично</option>
                    <option value="1" <?= $absence->getIsFull() == AbsenseType::FULL ? "selected" : "" ?>>Цялостно</option>
                </select>

                <label for="created_on">Дата на създаване:</label>
                <input type="datetime-local" id="created_on" name="created_on" required value="<?= $date ?>">
                <button type="submit" class="submit-button submit-button-main">
                    <?php if ($absence->getId() == null) { ?>
                        Добави отсъствие
                    <?php } else { ?>
                        Редактирай отсъствие
                    <?php } ?>
                </button>
            </form>
        </section>
    <?php
    }

    public function renderSubjectAbsenses($absences)
    {
        $count = 1;
    ?>
        <section>
            <h3>Списък с отсъствия:</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Тип отсъствие</th>
                        <th>Дата на създаване</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($absences as $absence) { ?>
                        <tr>
                            <td><?= $count++; ?></td>
                            <td>
                                <?php
                                if ($absence->getIsFull() == AbsenseType::PARTIAL) {
                                    echo "Частично";
                                } else {
                                    echo "Цялостно";
                                }
                                ?>
                            </td>
                            <td><?= $absence->getCreatedOn() ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>
    <?php
    }

    public function renderAllAbsences(array $absencesCount)
    {
    ?>
        <section class="user-form">
            <h2>Общ брой отсъствия</h2>
        </section>

        <section>
            <table class="table">
                <thead>
                    <tr>
                        <th>Частично отсъствие</th>
                        <th>Пълно отсъствие</th>
                        <th>Общо</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $absencesCount[AbsenseType::PARTIAL_TEXT] ?></td>
                        <td><?= $absencesCount[AbsenseType::FULL_TEXT] ?></td>
                        <td><?= $absencesCount[AbsenseType::TOTAL_TEXT] ?></td>
                    </tr>
                </tbody>
            </table>
        </section>
<?php
    }
}
