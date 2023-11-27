<?php

namespace App\Views;

use App\Models\SubjectTopicModel;

class SubjectTopicView extends BaseView
{
    public function renderAddForm($subject_id)
    {
        $this->renderBack();
?>
        <section class="data-form">
            <form action="index.php?p=subject-topic-management" method="post">
                <input type="hidden" id="subject_id" name="subject_id" value="<?= $subject_id ?>">

                <label for="topic_name">Име на темата:</label>
                <input type="text" id="topic_name" name="topic_name" required>

                <label for="topic_week">Седмица:</label>
                <input type="number" min="1" id="topic_week" name="topic_week" required>

                <button type="submit" class="submit-button submit-button-main">
                    Добави тема
                </button>
            </form>
        </section>
    <?php
    }

    public function renderEditForm(SubjectTopicModel $topic)
    {
        $this->renderBack();
    ?>
        <section class="data-form">
            <form action="index.php?p=subject-topic-management" method="post">
                <input type="hidden" id="topic_id" name="topic_id" value="<?= $topic->getId() ?>">

                <label for="topic_name">Име на темата:</label>
                <input type="text" id="topic_name" name="topic_name" value="<?= $topic->getName() ?>" required>

                <label for="topic_week">Седмица:</label>
                <input type="number" min="1" id="topic_week" value="<?= $topic->getWeek() ?>" name="topic_week" required>

                <button type="submit" class="submit-button submit-button-main">
                    Редактирай тема
                </button>
            </form>
        </section>
    <?php
    }

    public function renderTableTopics($topics)
    {
        $count = 1;

    ?>
        <table class="table">
            <thead>
                <tr>
                    <th>№</th>
                    <th>Седмица</th>
                    <th>Тема</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($topics as $topic) { ?>
                    <tr>
                        <td><?= $count++ ?></td>
                        <td><?= $topic->getWeek() ?></td>
                        <td><?= htmlspecialchars($topic->getName()) ?></td>
                        <td>
                            <a href="index.php?p=subject-topic-management&subject_id=<?= $topic->getSubjectId() ?>&topic_id=<?= $topic->getId() ?>" class="action-button">
                                Редактирай
                            </a>
                            <br>
                            <a href="index.php?p=subject-topic-management&subject_id=<?= $topic->getSubjectId() ?>&delete_id=<?= $topic->getId() ?>" class="action-button">
                                Изтрий
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
<?php
    }
}
