<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\UserManager;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $userManager = new UserManager();
        // si l'utilisateur est connecté 
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user']['id'];

            $data['user'] = $userManager->getById($userId);

            if ($data['user']) {
                $this->render(__DIR__ . '/../views/template_profile.phtml', $data);
            } else {
                echo "utilisateur inconnue";
            }
        } else {
            echo 'Il faut se connecter';
        }
    }


    public function login()
    {
        $data = [];
        if (isset($_POST['submit'])) {
            $mail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            if (!empty($mail) && !empty($password)) {
                $userManager = new UserManager();
                $user = $userManager->getUserByEmail($mail);


                if ($user) {
                    $hashedPasswordFromDatabase = $user['password'];
                    if (password_verify($password, $hashedPasswordFromDatabase)) {
                        $successMessage = 'Connexion réussie !';
                        $data['successMessage'] = $successMessage;
                        $_SESSION['user'] = $user;
                        $_SESSION['user']['id'] = $user['id'];

                        header('Location: index.php?page=user&action=index');
                    }
                } else {
                    $errorMessage = 'Aucun utilisateur trouvé avec cette adresse e-mail.';
                }
                // return $errorMessage;// !!!!!! ERREUR NON RETOURNÉE (undefined)
            }
        }
        $this->render(__DIR__ . '/../views/template_login.phtml', $data);
    }


    public function register()
    {
        if (isset($_POST['submit'])) {
            $roles = isset($_POST['roles']) ? explode(",", $_POST['roles']) : [];
            $strRoles = json_encode($roles);

            $user = new User();
            $user->setUserName($_POST['name']);
            $user->setEmail($_POST['email']);
            $user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
            $user->setRoles($strRoles);

            $errors = $user->validate();

            if (empty($errors)) {
                $userManager = new UserManager();
                $userManager->insert($user->toArray());
                header('Location: index.php?page=user&action=login');
                exit; // Ajouté pour arrêter l'exécution après la redirection
            }
        }

        $this->render(__DIR__ . '/../views/template_register.phtml', []);
    }
}
