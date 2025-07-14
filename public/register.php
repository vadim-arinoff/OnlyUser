<?php 

require_once __DIR__ . '/../boot.php';

$errors = [];
$old_data = [];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $old_data = $_POST;

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $password_confirm = trim($_POST['password_confirm'] ?? '');

    if(empty($name)){
        $errors['name'] = 'Пожалуйста, введите имя.';
    }
    if(empty($email)){
        $errors['email'] = 'Пожалуйста, введите почту.';
    }
    if(empty($phone)){
        $errors['phone'] = 'Пожалуйста, введите телефон.';
    }
    if(empty($password)){
        $errors['password'] = 'Пожалуйста, введите пароль.';
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors ['email'] = 'Введите корректный email адрес.';
    }

    if ($password != $password_confirm){
        $errors ['password'] = 'Пароли не совпадают';
    }

    if(empty($errors)){
        if($user->exists($email, $phone)){ //либо if ($user->findByLogin($email)) $errors['email'] = 'Этот email уже занят.';
            $errors ['form'] = 'Пользователь с такой почтой и телефоном уже зарегестрирован.';
        } else {

        $user->create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => $password,
        ]);
        header('Location: /login.php?status=success_register');
        exit();
        }
    }
}
require_once __DIR__ . '/temp/header.php';
?>

<h1>Регистрация</h1>
<?php if (isset ($errors['form'])): ?>
    <p style="color: red;"><?= $errors['form'] ?></p>
    <?php endif; ?>
        
<form action="/register.php" method="POST">
    <div>
        <label for="name">Имя:</label><br>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($old_data['name'] ?? '')?>">
        <?php if (isset($errors['name'])): ?>
            <p style="color: red;"><?= $errors['name'] ?></p>
        <?php endif; ?>
    </div>
    <br>
    <div>
    <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($old_data['email'] ?? '') ?>">
        <?php if (isset($errors['email'])): ?>
            <p style="color: red;"><?= $errors['email'] ?></p>
        <?php endif; ?>
    </div>
    <br>
    <div>
        <label for="phone">Телефон:</label><br>
        <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($old_data['phone'] ?? '') ?>">
        <?php if (isset($errors['phone'])): ?>
            <p style="color: red;"><?= $errors['phone'] ?></p>
        <?php endif; ?>
    </div>
    <br>
    <div>
        <label for="password">Пароль:</label><br>
        <input type="password" id="password" name="password">
        <?php if (isset($errors['password'])): ?>
            <p style="color: red;"><?= $errors['password'] ?></p>
        <?php endif; ?>
    </div>
    <br>
    <div>
        <label for="password_confirm">Повторите пароль:</label><br>
        <input type="password" id="password_confirm" name="password_confirm">
        <?php if (isset($errors['password_confirm'])): ?>
            <p style="color: red;"><?= $errors['password_confirm'] ?></p>
        <?php endif; ?>
    </div>
    <br>
    <button type="submit">Зарегестрироваться</button>
</form>

<?php
require_once __DIR__ . '/temp/footer.php';