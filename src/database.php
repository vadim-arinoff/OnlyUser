<?php

class Database{

    private ?PDO $pdo = null;

    public function __construct()
    {
        $dsn = 'pgsql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
    
    try {
        $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e){
        error_log ('Connection error: ' . $e->getMessage());
        die('Ошибка при подключении к базе данных. Попробуйте позже');
    }
}
    public function getConn()
    {
        if ($this->pdo) {
        return $this->pdo;
    }
        return "Ошибка подключения";
    }
}