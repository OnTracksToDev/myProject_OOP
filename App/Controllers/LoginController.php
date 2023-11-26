<?php
namespace App\Controllers;
use App\Controllers\Controller;
use App\Services\Authentication;

class LoginController extends Controller
{
    public function index()
    {
        $errors = [];
        if (isset($_POST['submit'])) {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];

            $auth = new Authentication();
            if ($auth->login($email,$password)){
                header("Location:?page=home"); 
            }
            $errors[] = "Problème d'authentification !";
        }
        $this->render(__DIR__ . '/../views/template_login.phtml', [
            'errors' => $errors
        ]);
    }
}

