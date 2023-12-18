<?php
namespace App\Services;
use App\Models\UserManager;

class Authentication
{
    public function __construct()
    {
        if (!isset($_SESSION)) session_start();
    }

    public static function isNotAllowed(string $role): bool
    {
        $check = (!isset($_SESSION['user']) || !in_array($role,json_decode($_SESSION['user']['roles'])));
        return $check; 
    }

    public function setSessionData(array $userData): void
    {
        $_SESSION['user'] = $userData;
    }

    public function login(string $email, string $password): bool
    {
        $verif = false;
        $userManager = new UserManager();
        $user = $userManager->getUserByEmail($email);
    
        if ($user && password_verify($password, $user['password'])) {
            // Vérif utilisateur supprimé
            if ($user['deleted_at'] === null) {
                $verif = true;
                $this->setSessionData($user);
            }
        }
    
        return $verif;
    }
    
    public function logout(): void
    {
        session_destroy();
    }

}
