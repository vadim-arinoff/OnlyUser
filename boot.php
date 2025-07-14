<?php

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

require_once __DIR__ . '/config.php';

spl_autoload_register(function ($className) {
    $file = __DIR__ . '/src/' . $className . '.php';
    if (file_exists($file)){
        require_once $file;
    }
});

$db = new Database();

$pdo = $db->getConn();
$user = new User($pdo);
$auth = new Auth($user);