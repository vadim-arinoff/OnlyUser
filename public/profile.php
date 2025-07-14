<?php
require_once __DIR__ . '/../boot.php';

$auth->check();
$userId = $auth->id();
$currentUser = $user->find($userId);

$info_success = null;
$info_error = null;
$password_success = null;
$password_error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;

    if ($action === 'update_info') {
        $newName = trim($_POST['name'] ?? '');
        $newEmail = trim($_POST['email'] ?? '');
        $newPhone = trim($_POST['phone'] ?? '');

        if (empty($newName) || empty($newEmail) || empty($newPhone)) {
            $info_error = 'Все поля должны быть заполнены.';
        }
        elseif ($user->exists($newEmail, $newPhone, $userId)) {
            $info_error = 'Такой email или телефон уже используется другим пользователем.';
        } else {
            $user->updateInfo($userId, ['name' => $newName, 'email' => $newEmail, 'phone' => $newPhone]);
            $info_success = 'Ваши данные успешно обновлены!';
            $currentUser = $user->find($userId);
        }
    }

    if ($action === 'change_password') {
        $oldPassword = $_POST['old_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $newPasswordConfirm = $_POST['new_password_confirm'] ?? '';

        $userData = $user->findByLogin($currentUser->email);
        
        if (empty($oldPassword) || empty($newPassword) || empty($newPasswordConfirm)) {
            $password_error = 'Все поля для смены пароля должны быть заполнены.';
        } elseif (!password_verify($oldPassword, $userData['password_hash'])) {
            $password_error = 'Старый пароль введен неверно.';
        } elseif ($newPassword !== $newPasswordConfirm) {
            $password_error = 'Новые пароли не совпадают.';
        } else {
            $user->updatePassword($userId, $newPassword);
            $password_success = 'Пароль успешно изменен!';
        }
    }
}

require_once __DIR__ . '/temp/header.php';
?>

<h1>Мой профиль</h1>
<p>Здесь вы можете изменить свою личную информацию и пароль.</p>

<hr>

<h3>Изменить личные данные</h3>

<?php if ($info_success): ?><p style="color: green;"><?= $info_success ?></p><?php endif; ?>
<?php if ($info_error): ?><p style="color: red;"><?= $info_error ?></p><?php endif; ?>

<form action="/profile.php" method="POST">
    <input type="hidden" name="action" value="update_info">
    <div>
        <label for="name">Имя:</label><br>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($currentUser->name) ?>">
    </div>
    <br>
    <div>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($currentUser->email) ?>">
    </div>
    <br>
    <div>
        <label for="phone">Телефон:</label><br>
        <input type="tel" id="phone" name="phone" value="<?= htmlspecialchars($currentUser->phone) ?>">
    </div>
    <br>
    <button type="submit">Сохранить изменения</button>
</form>

<hr>

<h3>Сменить пароль</h3>

<?php if ($password_success): ?><p style="color: green;"><?= $password_success ?></p><?php endif; ?>
<?php if ($password_error): ?><p style="color: red;"><?= $password_error ?></p><?php endif; ?>

<form action="/profile.php" method="POST">
    <input type="hidden" name="action" value="change_password">
    <div>
        <label for="old_password">Старый пароль:</label><br>
        <input type="password" id="old_password" name="old_password">
    </div>
    <br>
    <div>
        <label for="new_password">Новый пароль:</label><br>
        <input type="password" id="new_password" name="new_password">
    </div>
    <br>
    <div>
        <label for="new_password_confirm">Повторите новый пароль:</label><br>
        <input type="password" id="new_password_confirm" name="new_password_confirm">
    </div>
    <br>
    <button type="submit">Сменить пароль</button>
</form>

<?php
require_once __DIR__ . '/temp/footer.php';
?>