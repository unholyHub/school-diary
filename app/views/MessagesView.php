<?php

namespace App\Views;

use App\Models\MessageModel;

class MessageView
{
    public function renderMessageBox($user)
    {
?>
        <section class="data-form">
            <form method="post" action="index.php?p=message-page">
                <input type="hidden" name="user_id" value="<?= $user->getId(); ?>">

                <label for="message">
                    Съобщение до <strong><?= $user->getFullName() ?></strong>:
                </label>

                <textarea id="message" name="message" rows="4" cols="50" required></textarea>
                <button type="submit" class="submit-button ">Изпрати</button>
            </form>
        </section>
    <?php
    }

    public function renderEditForm(MessageModel $message)
    {
    ?>
        <section class="data-form">
            <form method="post" action="index.php?p=message-page">
                <input type="hidden" name="message_id" value="<?= $message->getId(); ?>">
                <input type="hidden" name="user_id" value="<?= $message->getToUserId(); ?>">

                <label for="message">
                    Съобщение до <strong><?= $message->getToFullName() ?></strong>:
                </label>

                <textarea id="message" name="message" rows="4" cols="50" required><?= $message->getMessage(); ?></textarea>
                <button type="submit" class="submit-button ">Запази промените</button>
            </form>
        </section>
    <?php
    }

    public function renderMessagesToUser($messages)
    {
        if (count($messages) == 0) {
            echo "<p>Няма съобщения</p>";
            return;
        }

    ?>

        <table class="table">
            <thead>
                <tr>
                    <th>Учител</th>
                    <th>Съобщение</th>
                    <th>Изпратено на</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $message) { ?>
                    <tr>
                        <td><?= $message->getFromFullName() ?></td>
                        <td><?= $message->getMessage() ?></td>
                        <td><?= $message->getSentOn() ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php
    }


    public function renderMessagesToUserFromMod($messages)
    {
        if (count($messages) == 0) {
            echo "<p>Няма съобщения</p>";
            return;
        }

    ?>

        <table class="table">
            <thead>
                <tr>
                    <th>Учител</th>
                    <th>Съобщение</th>
                    <th>Изпратено на</th>
                    <th>Действия</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $message) { ?>
                    <tr>
                        <td><?= $message->getFromFullName() ?></td>
                        <td><?= $message->getMessage() ?></td>
                        <td><?= $message->getSentOn() ?></td>
                        <td>
                            <a href="index.php?p=message-page&student_id=<?= $message->getToUserId() ?>&message_id=<?= $message->getId() ?>">
                                Редактирай
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
<?php
    }
}
