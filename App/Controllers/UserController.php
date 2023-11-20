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
            
            $data['user'] = $userManager->getUserById($userId);

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
                $user = $userManager->getUserByMail($mail);
                

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
        // On instancie la class User pour créer un nouvel utilisateur
        $user = new User();
        // On anticipe d'éventuelles erreurs en créant un tableau
        $errors = [];
        if (isset($_POST['submit'])) {
            // Si le formulaire est validé on "hydrate" notre objet
            // avec les informations du formulaire
            $user->setUserName($_POST['username']);
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
            // Si la méthode validate ne retourne pas d'erreurs on fait l'insert dans la table
            $errors = $user->validate();
            if (empty($errors)) {
                // On transforme l'objet User courant en tableau
                // Avec uniquement les valeurs des propriétés
                // Voir la methode toArray() dans User.php
                $userArray = $user->toArray();
                // On instancie un UserManager
                $userManager = new UserManager();
                // On effectue l'insert dans la table
                $insert = $userManager->createUser($userArray);
                // ON redirige !
                header('Location: index.php?page=user&action=login');
            }
        }
        $this->render(__DIR__ . '/../views/template_register.phtml', [
            '$_POST' => $_POST,
            'user' => $user,
            'errors' => $errors
        ]);
    }
}
