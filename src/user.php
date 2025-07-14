<?php

class User
{
    private PDO $pdo;
    public ?int $id = null;
    public ?string $name = null;
    public ?string $email = null;
    public ?string $phone = null;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function find(int $id): ?self
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        
        $stmt->setFetchMode(PDO::FETCH_CLASS, self::class, [$this->pdo]); //результат нужно преобразовать в объект этого класса, ошибка, возвращала массив
        $stmt->execute([$id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findByLogin(string $login): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ? OR phone = ?");
        $stmt->execute([$login, $login]);
        return $stmt->fetch();
    }

    public function exists(string $email, string $phone, ?int $excludeUserId = null): bool
    {
        $sql = "SELECT 1 FROM users WHERE (email = ? OR phone = ?) ";
        $params = [$email, $phone];

        if ($excludeUserId !== null) {
            $sql .= "AND id != ?";
            $params[] = $excludeUserId;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (bool) $stmt->fetchColumn();
    }

    public function updateInfo(int $id, array $data): bool
    {
        $sql = "UPDATE users SET name = ?, email = ?, phone = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$data['name'], $data['email'], $data['phone'], $id]);
    }

    public function updatePassword(int $id, string $newPassword): bool
    {
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password_hash = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$newPasswordHash, $id]);
    }

    public function create(array $data): bool
    {
        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, phone, password_hash) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $data['name'],
            $data['email'],
            $data['phone'],
            $passwordHash
        ]);
    }
}