<?php

namespace App\Views;

use App\Helpers\DateTimeHelper;
use App\Models\SubjectScheduleModel;
use DaysOfWeek;

class SubjectScheduleView extends BaseView
{
    public function renderAddButton($url)
    {
?>
        <section class="data-form">
            <a class="submit-button submit-button-main" href="<?= $url ?>">
                Добави разписание
            </a>
        </section>
    <?php

    }

    public function renderSubjectSchedules(array $schedules)
    {
        $subject_id = isset($_GET['subject_id']) ? "&subject_id=" . $_GET['subject_id'] : "";
    ?>
        <?php
        if (count($schedules) == 0) {
        ?>
            <p>Нямз разписание</p>
        <?php
            return;
        }
        ?>

        <table class="table">
            <thead>
                <tr>
                    <th>Дата на разписание</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($schedules as $schedule) { ?>
                    <tr>
                        <td><?= $schedule->getScheduleDate(); ?></td>
                        <td>
                            <a href="index.php?p=subject-schedule-info&schedule_id=<?= $schedule->getId(); ?>">Редактирай</a><br>
                            <a href="index.php?p=subject-schedule&del=<?php echo $schedule->getId(), $subject_id; ?>">Изтрий</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php
    }


    public function renderAddScheduleForm($url, SubjectScheduleModel $schedule, $subjects, $classes)
    {
        $this->renderBack();

    ?>
        <section class="data-form">
            <form action="<?= $url ?>" method="post">

                <?php
                $this->renderError();
                if ($schedule->getId() !== null) {
                ?>
                    <input type="hidden" name="schedule_id" value="<?= $schedule->getId(); ?>">
                <?php } ?>

                <label for="subject_id">Предмет:</label>
                <select id="subject_id" name="subject_id" required>
                    <option disabled selected value>
                        Изберете предмет, за да се заредят класовете...
                    </option>
                    <?php foreach ($subjects as $subject) { ?>
                        <option value="<?= $subject->getId(); ?>" <?php if ($schedule->getSubjectId() == $subject->getId()) echo 'selected'; ?>>
                            <?= $subject->getName(); ?>
                        </option>
                    <?php } ?>
                </select>

                <label for="class_id">Клас:</label>
                <select id="class_id" name="class_id" required>
                    <option disabled selected value>
                        Изберете предмет, за да се заредят класовете...
                    </option>
                    <?php foreach ($classes as $c) { ?>
                        <option value="<?= $c->getId(); ?>" <?php if ($schedule->getClassId() == $c->getId()) echo 'selected'; ?>>
                            <?= $c->getFullClassName(); ?>
                        </option>
                    <?php } ?>
                </select>

                <label for="day">Ден от седмицата:</label>
                <select id="day" name="day" required>
                    <option>Избери ден...</option>
                    <option value="1" <?= $schedule->getDay() === "1" ? "selected" : "" ?>>Понеделник</option>
                    <option value="2" <?= $schedule->getDay() === "2" ? "selected" : "" ?>>Вторник</option>
                    <option value="3" <?= $schedule->getDay() === "3" ? "selected" : "" ?>>Сряда</option>
                    <option value="4" <?= $schedule->getDay() === "4" ? "selected" : "" ?>>Четвъртък</option>
                    <option value="5" <?= $schedule->getDay() === "5" ? "selected" : "" ?>>Петък</option>
                </select>

                <label for="program_slot">Час по програма:</label>
                <select id="program_slot" name="program_slot" required>
                    <option>Избери час...</option>
                    <option value="1" <?= $schedule->getProgramSlot() == "1" ? "selected" : "" ?>>1</option>
                    <option value="2" <?= $schedule->getProgramSlot() == "2" ? "selected" : "" ?>>2</option>
                    <option value="3" <?= $schedule->getProgramSlot() == "3" ? "selected" : "" ?>>3</option>
                    <option value="4" <?= $schedule->getProgramSlot() == "4" ? "selected" : "" ?>>4</option>
                    <option value="5" <?= $schedule->getProgramSlot() == "5" ? "selected" : "" ?>>5</option>
                    <option value="6" <?= $schedule->getProgramSlot() == "6" ? "selected" : "" ?>>6</option>
                    <option value="7" <?= $schedule->getProgramSlot() == "7" ? "selected" : "" ?>>7</option>
                </select>

                <label for="program_time_start">Час започва:</label>
                <input type="time" id="program_time_start" min="07:30" max="14:00" name="program_time_start" required value="<?= $schedule->getProgramTimeStart(); ?>">

                <label for="program_time_end">Часът приключва:</label>
                <input type="time" id="program_time_end" min="07:30" max="14:00" name="program_time_end" required value="<?= $schedule->getProgramTimeEnd(); ?>">

                <button type="submit" class="submit-button submit-button-main">
                    <?php if ($schedule->getId() === null) { ?>
                        Създай
                    <?php } else { ?>
                        Редактирай
                    <?php } ?>
                </button>
            </form>
        </section>
        <?php
    }

    public function renderError()
    {
        if (isset($_GET['error_notfree'])) {
        ?>
            <p class="error_notfree">
                <?= $_GET['error_notfree'] ?>
            </p>
        <?php
        }

        if (isset($_GET['error'])) {
        ?>
            <p class="error">
                Часът на започване не може да е по-голямо от часът на завършване
            </p>
        <?php
        }
    }


    public function renderWeekSchedule($schedules)
    {
        $daysOfWeek = [];

        for ($i = 0; $i < 7; $i++) {
            $daysOfWeek[DaysOfWeek::MONDAY - 1][$i] = new SubjectScheduleModel();
            $daysOfWeek[DaysOfWeek::TUESDAY - 1][$i] = new SubjectScheduleModel();
            $daysOfWeek[DaysOfWeek::WEDNESDAY - 1][$i] = new SubjectScheduleModel();
            $daysOfWeek[DaysOfWeek::THURSDAY - 1][$i] = new SubjectScheduleModel();
            $daysOfWeek[DaysOfWeek::FRIDAY - 1][$i] = new SubjectScheduleModel();
        }

        foreach ($schedules as $s) {
            $daysOfWeek[$s->getDay() - 1][$s->getProgramSlot() - 1] = $s;
        }


        ?>
        <div class="tab">
            <button id="openByDefault" class="tablinks" onclick="openCity(event, 'Monday')">Понеделник</button>
            <button class="tablinks" onclick="openCity(event, 'Tuesday')">Вторник</button>
            <button class="tablinks" onclick="openCity(event, 'Wednesday')">Сряда</button>
            <button class="tablinks" onclick="openCity(event, 'Thursday')">Четвъртък</button>
            <button class="tablinks" onclick="openCity(event, 'Friday')">Петък</button>
        </div>

        <?php
        for ($d = 0; $d < 5; $d++) {
        ?>
            <div id="<?= DaysOfWeek::getDayTextEnglish($d + 1) ?>" class="tabcontent">
                <table class="table">
                    <thead>
                        <tr>
                            <!-- 1 -->
                            <th>Час</th>
                            <!-- 2 -->
                            <th>Час начало</th>
                            <!-- 3 -->
                            <th>Час край</th>
                            <!-- 4 -->
                            <th>Клас</th>
                            <!-- 5 -->
                            <th>Предмет</th>
                            <!-- 6 -->
                            <th>Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($h = 0; $h < 7; $h++) {
                            $daySchedule = $daysOfWeek[$d][$h];
                        ?>
                            <tr>
                                <td>
                                    <?= $h + 1 ?>
                                </td>
                                <?php
                                if ($daySchedule->getId() == null) { ?>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>
                                        <a href="index.php?p=schedule-add">
                                            Добави
                                        </a>
                                    </td>
                                <?php
                                } else {
                                ?>
                                    <td>
                                        <?= DateTimeHelper::convertTimeFormat($daySchedule->getProgramTimeStart()) ?>
                                    </td>
                                    <td>
                                        <?= DateTimeHelper::convertTimeFormat($daySchedule->getProgramTimeEnd()) ?>
                                    </td>
                                    <td>
                                        <?= $daySchedule->getClassName() ?>
                                    </td>
                                    <td>
                                        <?= $daySchedule->getSubjectName() ?>
                                    </td>
                                    <td>
                                        <a href="index.php?p=schedule-add&schedule_id=<?= $daySchedule->getId() ?>">
                                            Редактирай
                                        </a>
                                        <br>

                                        <a href="index.php?p=schedule-management&delete_id=<?= $daySchedule->getId() ?>">
                                            Изтрий
                                        </a>
                                    </td>
                            <?php
                                }
                            }
                            ?>
                            </tr>
                    </tbody>
                </table>
            </div>
        <?php
        }
        ?>
<?php
    }

    private function renderOneDay(SubjectScheduleModel $schedule)
    {
    }
}
