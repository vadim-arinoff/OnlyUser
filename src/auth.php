<?php

class Auth
{
    private User $user;
    
    public function __construct(User $user)
    {
        $this->user = $user;

        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login(string $login, string $password): bool
    {
        $userData = $this->user->findByLogin($login);

        if(!$userData || !password_verify($password, $userData['password_hash'])){
            return false;
        }

        session_regenerate_id(true);

        $_SESSION['user_id'] = (int)$userData['id'];

        return true;
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public function id(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    public function user(): ?User
    {
        if(!$this->isLoggedIn()){
            return null;
        }

        return $this->user->find($this->id());
    }

    public function logOut()
    {
        $_SESSION = [];
        session_destroy();
    }

    public function check ()
    {
        if (!$this->isLoggedIn()){
            header('Location: /login.php');
            exit();
        }
    }
}