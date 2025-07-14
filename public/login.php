<?php

require_once __DIR__ . '/../boot.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $captcha = new Captcha(YANDEX_CAPTCHA_SERVER_KEY);
    $captchaToken = $_POST['smart-token'] ?? null;
    $userIp = $_SERVER['REMOTE_ADDR'] ?? null;

    if($captcha->verify($captchaToken, $_SERVER['REMOTE_ADDR'])){
        $login = $_POST['login'] ?? '';
        $password = $_POST['password'] ?? '';

        if($auth->login($login, $password)){
            header('Location: /profile.php');
            exit();
        } else {
            $error = 'Неверный логин или пароль.';
        }
    } else {
        $error = 'Пожалуйста, подвтердите что вы не робот.';
    }
}

require_once __DIR__ . '/temp/header.php';
?>

<h1>Вход в аккаунт</h1>

<?php if (isset($_GET['status']) && $_GET['status'] === 'success_register'): ?>
    <p style="color: green;">Вы успешно зарегистрированы! Теперь можете войти.</p>
<?php endif; ?>

<?php if ($error): ?>
    <p style="color: red;"><?= $error ?></p>
<?php endif; ?>

<form action="/login.php" method="POST">
    <div>
        <label for="login">Email или телефон:</label><br>
        <input type="text" id="login" name="login" required>
    </div>
    <br>
    <div>
        <label for="password">Пароль:</label><br>
        <input type="password" id="password" name="password" required>
    </div>
    <br>

    <div
        id="captcha-container"
        class="smart-captcha"
        data-sitekey="<?= YANDEX_CAPTCHA_CLIENT_KEY ?>"
    ></div>
    <br>

    <button type="submit">Войти</button>
</form>

<?php
require_once __DIR__ . '/temp/footer.php';