<?php

require_once __DIR__ . '/../boot.php';

$auth->logout();

header('Location: /');
exit();