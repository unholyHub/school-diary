<?php

namespace App\Views;

use App\Constants\AccessLevel;
use App\Constants\SubjectType;
use App\Models\UserModel;

class UserView extends BaseView
{
    public function __construct()
    {
    }

    public function renderStudentName(UserModel $student)
    {
?>
        <section class="data-form">
            <h2>
                <?= $student->getFullName(), ' (', $student->getClass(), ' клас)' ?>
            </h2>
        </section>
    <?php
    }


    public function renderTeacherSubjects(
        $url,
        UserModel $teacher,
        array $subjects
    ) {
    ?>
        <section class="data-form">
            <form method="post" action="<?= $url ?>">
                <?php
                $user_id = $teacher->getId();
                echo '<input type="hidden" name="user_id" value="', $user_id, '">';
                ?>
                <p>Учител:
                    <strong>
                        <?php echo
                        $teacher->getFirstName(), ' ',
                        $teacher->getLastName(); ?>
                    </strong>
                </p>
                <?php if (count($subjects) > 0) { ?>
                    <label for="subject_id">Избери предмет за премахване:</label>
                    <select id="subject_id" name="subject_id">
                        <option selected value disabled>Избери...</option>
                        <?php foreach ($subjects as $subject) {
                            $subject_type = $subject->getIsMain() == SubjectType::MAIN ? "основен" : "клуб";
                        ?>
                            <option value="<?php echo $subject->getId(); ?>">
                                <?php
                                echo
                                $subject->getName(), " (",
                                $subject_type, ", ",
                                $subject->getMinStartingGrade(), " клас)"

                                ?>
                            </option>
                        <?php } ?>
                    </select>
                <?php } else { ?>
                    <p>Няма добавени предмети/клубове.</p>
                <?php } ?>

                <?php if (count($subjects) > 0) { ?>
                    <input type="submit" class="submit-button" value="Премахни">
                <?php } ?>
            </form>
        </section>

    <?php
    }


    public function renderSearchBox($url)
    {
    ?>
        <section class="user-form">
            <form method="POST" action="<?= $url ?>">
                <label for="searchterm">Търси потребител:</label>
                <input type="text" name="searchterm" id="searchterm" placeholder="Въведете поле за търсене" <?php
                                                                                                            if (isset($_POST["searchterm"])) {
                                                                                                                echo 'value="', $_POST["searchterm"], '"';
                                                                                                            }
                                                                                                            ?> required>
                <button class="submit-button submit-button-main">Търси</button>
            </form>

            <a class="submit-button submit-button-main" href="index.php?p=user-page">
                Добави потребител
            </a>
        </section>
    <?php
    }

    public function renderUserDataForm($url, UserModel $selectedUser)
    {
        $this->renderBack();

    ?>
        <section class="data-form">
            <form action="<?= $url ?>" method="post" enctype="multipart/form-data">
                <?php if ($selectedUser->getId() !== NULL) { ?>
                    <input type="hidden" name="user_id" value="<?= $selectedUser->getId() ?>">
                <?php } ?>

                <?php if ($selectedUser->getProfilePicture() !== null) { ?>
                    <div>
                        <img alt="Липсва снимка" src="uploads/<?= $selectedUser->getProfilePicture() ?>">
                    </div>
                <?php } ?>

                <label for="username">Потребителско име:</label>
                <input type="text" id="username" name="username" required value="<?= $selectedUser->getUsername() ?>">

                <label for="password">Парола:</label>
                <input type="password" id="password" name="password" maxlength="12" required value="<?= $selectedUser->getPassword() ?>">

                <div class="password-field signup-toggle">
                    <span><i id="toggler" class="far fa-eye"></i></span>
                </div>

                <label for="first_name">Име:</label>
                <input type="text" id="first_name" name="first_name" required value="<?= $selectedUser->getFirstName() ?>">

                <label for="last_name">Фамилия:</label>
                <input type="text" id="last_name" name="last_name" required value="<?= $selectedUser->getLastName() ?>">

                <label for="phone_number">Телефонен номер:</label>
                <input type="text" id="phone_number" name="phone_number" required value="<?= $selectedUser->getPhoneNumber() ?>">

                <?php if ($selectedUser->getRole() == 3) { ?>
                    <label for="parent_email">Email родител:</label>
                    <input type="email" id="parent_email" name="parent_email" value="<?= $selectedUser->getParentEmail() ?>">
                <?php } ?>

                <label for="user_role">Роля:</label>
                <select id="user_role" name="user_role" required>
                    <option selected value disabled>Избери...</option>
                    <option value="1" <?php if ($selectedUser->getRole() == 1) echo 'selected'; ?>>Администратор</option>
                    <option value="2" <?php if ($selectedUser->getRole() == 2) echo 'selected'; ?>>Учител</option>
                    <option value="3" <?php if ($selectedUser->getRole() == 3) echo 'selected'; ?>>Ученик</option>
                </select>

                <label for="profile_picture">Снимка:</label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" <?php if ($selectedUser->getProfilePicture() === null) {
                                                                                                    //echo 'required';
                                                                                                }
                                                                                                ?>>

                <button class="submit-button submit-button-main">
                    Промени
                </button>
            </form>
        </section>
    <?php
    }

    public function renderFoundUsers($foundUsers)
    {
    ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Имена</th>
                    <th>Тип</th>

                    <th>Паралелка</th>
                    <th>Телефон</th>

                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($foundUsers as $u) {
                    $className = $u->getRole() == AccessLevel::STUDENT ? $u->getClass() : "-";
                ?>
                    <tr>
                        <td><?php echo $u->getFirstName(), ' ', $u->getLastName(); ?></td>
                        <td>
                            <?= $u->getRoleName() ?>
                        </td>

                        <td>
                            <?= $className ?>
                        </td>

                        <td>
                            <?= $u->getPhoneNumber() ?>
                        </td>

                        <td>

                            <?php if ($u->getRole() === AccessLevel::TEACHER) { ?>
                                <a href="index.php?p=user-subjects&user_id=<?= $u->getId(); ?>&">
                                    Редактирай предмети
                                </a>
                                <br>
                            <?php } ?>

                            <?php if ($u->getRole() === AccessLevel::STUDENT) { ?>
                                <a href="index.php?p=user-class&user_id=<?= $u->getId(); ?>&">
                                    Редактирай клас
                                </a>
                                <br>

                                <a href="index.php?p=grades-management&student_id=<?= $u->getId(); ?>&class_id=<?= $u->getClassId() ?>">
                                    Редактирай оценки
                                </a>
                                <br>

                                <a href="index.php?p=absences-management&student_id=<?= $u->getId(); ?>&class_id=<?= $u->getClassId() ?>">
                                    Редактирай отсъствия
                                </a>
                                <br>
                            <?php } ?>

                            <a href="index.php?p=user-page&edit=<?= $u->getId(); ?>">Редактирай данни</a>
                            <br>

                            <a href="index.php?p=user-management&del=<?= $u->getId(); ?>">Изтрий</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php
    }

    public function renderFoundUsersForMessages($foundUsers)
    {
    ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Имена</th>
                    <th>Клас</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($foundUsers as $u) { ?>
                    <tr>
                        <td><?php echo $u->getFirstName(), ' ', $u->getLastName(); ?></td>
                        <td>
                            <?= $u->getClass() ?>
                        </td>
                        <td>
                            <a href="index.php?p=message-page&student_id=<?= $u->getId(); ?>">
                                Изпрати съобщение
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php
    }

    public function renderFoundUsersForFullInfo($foundUsers)
    {
    ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Имена</th>
                    <th>Клас</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($foundUsers as $u) { ?>
                    <tr>
                        <td><?php echo $u->getFirstName(), ' ', $u->getLastName(); ?></td>
                        <td>
                            <?= $u->getClass() ?>
                        </td>
                        <td>
                            <a href="index.php?p=student-page&student_id=<?= $u->getId(); ?>">
                                Виж пълна информация
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
<?php
    }
}
