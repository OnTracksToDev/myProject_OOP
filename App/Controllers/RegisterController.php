<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\User;
use App\Models\UserManager;

class RegisterController extends Controller
{

    public function index()
    {
        $user = new User();

        $errors = [];
        $userAdded = false;
        if (isset($_POST['submit'])) {
            

            $user->setUserName($_POST['username']);
            $user->setEmail($_POST['email']);
            $user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
            $user->setRoles('["ROLE_USER"]');
            $errors = $user->validate();

            if (empty($errors)) {
                $userArray = $user->toArray();
                var_dump($userArray);
                // On instancie un UserManager
                $userManager = new UserManager();
                // On effectue l'insert dans la table
                $userManager->insert($userArray); 
                $userAdded=true;   
                header('Location: index.php?page=user&action=login');
                exit; // Ajouté pour arrêter l'exécution après la redirection
            }
        }       
        $this->render(__DIR__ . '/../views/template_register.phtml', [
            'errors' => $errors,
            'userAdded' => $userAdded
        ]);
    }
}

