<?php

use App\Models\UserModel;

if (
    !isset($_SESSION['username']) &&
    (isset($_POST["username"]) && isset($_POST["password"]))
) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    require_once './app/controllers/UserController.php';
    $userRepository = new UserController($db);

    $result = $userRepository->login($username, $password);
    if ($result) {
        // Save username to session
        $_SESSION['username'] = $result;
    }
}

if (!isset($_SESSION['username'])) {
    $user = "";
    $pass = "";

?>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="username">Потребител:</label>
        <input type="text" name="username" id="username" placeholder="Потребител" required value="<?php echo $user; ?>">

        <label for="password">Парола:</label>
        <input type="password" name="password" id="password" placeholder="Парола" required value="<?php echo $pass; ?>">
        
        <div class="password-field signup-toggle">
            <span><i id="toggler" class="far fa-eye"></i></span>
        </div>


        <button class="submit-button">
            Влез
        </button>
    </form>

<?php
}

if (isset($_POST['username']) && !isset($_SESSION['username'])) {
    echo '<p class="login-error">Грешни данни!</p>';
}

if (isset($_SESSION['username'])) {
    require_once './app/models/UserModel.php';
    $loggedUser = UserModel::fromArray($_SESSION['username']);
?>

    <p>Здравейте,
        <?php echo
        $loggedUser->getFirstName(), ' ',
        $loggedUser->getLastName(),
        ' (<strong>', $loggedUser->getRoleName(), '</strong>)'
        ?>
    </p>
    <a class="signout" href="public/views/small-views/signout.php">Излез</a>

<?php } ?>