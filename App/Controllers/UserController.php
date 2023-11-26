<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\User;
use App\Models\UserManager;
use App\Services\Authentication;

class UserController extends Controller
{

    public function __construct()
    {

        if (!isset($_SESSION['user'])) {
            header("Location:?page=login");
            exit;
        }
    }

    public function index()
    {
        $userManager = new UserManager();
        // Si l'utilisateur est connecté
        if (isset($_SESSION['user'])) {
            $userId = $_SESSION['user']['id'];
            $data['user'] = $userManager->getById($userId);
            $data['comments'] = $userManager->getAllCommentsByUser($userId);
            $data['articles'] = $userManager->getAllArticlesByUser($userId);
            
            if ($data['user']) {
                $this->render(__DIR__ . '/../views/template_profile.phtml', $data);
            } else {
                echo "Utilisateur inconnu.";
            }
        } else {
            echo 'Il faut se connecter';
        }
    }

    public function editProfileUser()
    {
        $id = intval($_GET['id']);
        $userManager = new UserManager();
        $user = $userManager->getById($id);

        if (isset($_POST['submit'])) {
            if ($user !== null) {
                $editUser = new User();
                $editUser->setUserName($_POST['username']);
                $editUser->setEmail($_POST['email']);

                if (!empty($_POST['new_password'])) {
                    $editUser->setPassword(password_hash($_POST['new_password'], PASSWORD_DEFAULT));
                } else {
                    $editUser->setPassword($user['password']);
                }

                // rôles existants
                $existingRoles = $_SESSION['user']['roles'];
                $editUser->setRoles($existingRoles);

                $editUserArray = $editUser->toArray();
                $editUserArray[] = $id;

                $userManager = new UserManager();
                $userManager->update($editUserArray);
                header("Location:?page=user&action=index");
                exit;
            }
        }

        $this->render(__DIR__ . '/../views/template_profile_edit.phtml', [
            "user" => $user
        ]);
    }
}
