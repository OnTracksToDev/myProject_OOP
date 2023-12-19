<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\ArticleManager;
use App\Models\UserManager;

use App\Models\Article;
use App\Models\User;
use App\Services\Authentication;


class AdminController extends Controller
{

    public function __construct()
    {

        if (Authentication::isNotAllowed("ROLE_ADMIN")) {
            header("Location:?page=login");
        }
    }
    public function index()
    {
        $userManager = new UserManager();
        $articleManager = new ArticleManager();
        $data['articles'] = $articleManager->getAll();
        $data['users'] = $userManager->getAll();
        $this->render(__DIR__ . '/../views/admin/dashboard.phtml', $data);
    }
    /**
     * Users
     *  */
    public function manageUsers()
    {
        $userManager = new UserManager();
        $data['isActiveUsers'] = $userManager->getAllActiveUsers();
        $this->render(__DIR__ . '/../views/admin/users/manage_users.phtml', $data);
    }
    public function admin_EditUser()
    {
        $id = intval($_GET['id']);
        $userManager = new UserManager();
        $user = $userManager->getById($id);

        if (isset($_POST['submit'])) {
            if ($user !== null) {
                $editUser = new User();
                $editUser->setUserName($_POST['username']);
                $editUser->setEmail($_POST['email']);
                $editUser->setPassword($user['password']);
                // rôles existants
                $editUser->setRoles($_POST['role']);

                $editUserArray = $editUser->toArray();
                $editUserArray[] = $id;

                $userManager = new UserManager();
                $userManager->update($editUserArray);
                header("Location:?page=admin&action=manageUsers");
                exit;
            }
        }
        $this->render(__DIR__ . '/../views/admin/users/template_admin_edit_user.phtml', [
            "user" => $user
        ]);
    }
    public function admin_deleteUser()
    {
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $userManager = new UserManager();

            // Marquer l'utilisateur comme supprimé en mettant à jour la colonne deleted_at
            $userManager->softDeleteUser($id);

            header("Location:?page=admin&action=manageUsers");
        }
    }
    public function admin_addUser()
    {
        $user = new User();

        $errors = [];
        $userAdded = false;
        if (isset($_POST['submit'])) {


            $user->setUserName($_POST['username']);
            $user->setEmail($_POST['email']);
            $user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
            $user->setRoles($_POST['role']);
            $errors = $user->validate();

            if (empty($errors)) {
                $userArray = $user->toArray();
                var_dump($userArray);
                // On instancie un UserManager
                $userManager = new UserManager();
                // On effectue l'insert dans la table
                $userManager->insert($userArray);
                $userAdded = true;
                header('Location: index.php?page=admin&action=manageUsers');
                exit; // Ajouté pour arrêter l'exécution après la redirection
            }
        }
        $this->render(__DIR__ . '/../views/admin/users/template_admin_addUser.phtml', [
            'errors' => $errors,
            'userAdded' => $userAdded
        ]);
    }


    /**
     * Articles
     */
    public function manageArticles()
    {
        $articleManager = new ArticleManager();
        $data['articles'] = $articleManager->getAllActiveArticlesWithAuthors();
        $this->render(__DIR__ . '/../views/admin/articles/manage_articles.phtml', $data);
    }


    public function admin_deleteArticle()
    {
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $articleManager = new ArticleManager();

            // Marquer l'article comme supprimé en mettant à jour la colonne deleted_at
            $articleManager->softDeleteArticle($id);

            header("Location:?page=admin&action=manageArticles");
        }
    }


    public function admin_addArticle()
    {
        $article = new Article();

        $errors = [];
        $articleAdded = false;
        if (isset($_POST['submit'])) {

            $article->setUserId($_POST['user_id']);
            $article->setTitle($_POST['title']);
            $article->setContent($_POST['content']);
            $article->setImagePath($_POST['image_path']);
            $errors = $article->validate();

            if (empty($errors)) {
                $articleArray = $article->toArray();
                var_dump($articleArray);
                // On instancie un ArticleManager
                $articleManager = new ArticleManager();
                // On effectue l'insert dans la table
                $articleManager->insert($articleArray);
                $articleAdded = true;
                header('Location: index.php?page=admin&action=manageArticles');
                exit; // Ajouté pour arrêter l'exécution après la redirection
            }
        }
        $this->render(__DIR__ . '/../views/admin/articles/template_admin_addArticle.phtml', [
            'errors' => $errors,
            'articleAdded' => $articleAdded
        ]);
    }

    public function admin_EditArticle()
    {
        $id = intval($_GET['id']);
        $articleManager = new ArticleManager();
        $article = $articleManager->getById($id);

        if (isset($_POST['submit'])) {
            if ($article !== null) {

                $editArticle = new Article();
                $editArticle->setUserId($id);

                $editArticle->setTitle($_POST['title']);
                $editArticle->setContent($_POST['content']);
                $editArticle->setImagePath($_POST['image_path']);

                $editArticleArray = $editArticle->toArray();
                $editArticleArray[] = $id;

                $articleManager = new ArticleManager();
                $articleManager->update($editArticleArray);
                header("Location:?page=admin&action=manageArticles");
                exit;
            }
        }
        $this->render(__DIR__ . '/../views/admin/articles/template_admin_edit_article.phtml', [
            "article" => $article
        ]);
    }
}
