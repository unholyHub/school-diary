<?php

namespace App\Views;

class BaseView
{
    public function renderBack()
    {
?>
        <section class="back-button-section">
            <a class="submit-button submit-button-main" href="javascript:history.go(-1)">
                Назад
            </a>
        </section>
<?php
    }
}
