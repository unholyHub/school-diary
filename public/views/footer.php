</main>

<?php

use App\Helpers\JavaScriptManager;

$scripts = JavaScriptManager::getScripts();
foreach ($scripts as $script) {
    echo '<script src="' . $script . '"></script>';
}
?>

</body>
</html>