<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OnlyUser</title>
    <link rel="stylesheet" href="../css/style.css" />
</head>

<body>

<header>
<!-- container -->
    <div class="container">
        <div class="logo">
            <a href="/">OnlyUser</a>
        </div>
        <nav>
            <ul class="nav">
                <?php if ($auth->isLoggedIn()): ?>
                    <?php
                        $userName = htmlspecialchars($auth->user()->name, ENT_QUOTES, 'UTF-8');
                    ?>
                    <li class = "welcome-user">Привет, <?= $userName ?>!</li>
                    <li><a href="/profile.php">Профиль</a></li>
                    <li><a href="/logout.php">Выйти</a></li>
                <?php else: ?>
                    <li><a href="/login.php">Войти</a></li>
                    <li><a href="/register.php">Регистрация</a></li>
                <?php endif; ?>
        </ul>   
        </nav>
    </div>
    <script src="https://smartcaptcha.yandexcloud.net/captcha.js" defer></script>
</header>

<div class="container">
    <main>
