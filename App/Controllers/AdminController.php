<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\ArticleManager;
use App\Models\UserManager;


class AdminController extends Controller
{
    public function index()
    {
        $userManager = new UserManager();
        $articleManager = new ArticleManager();
        $data['articles'] = $articleManager->getAll();
        $data['users'] = $userManager->getAll();
        $this->render(__DIR__ . '/../views/admin/dashboard.phtml', $data);
    }



    public function manageUsers()
    {
        $userManager = new UserManager();
        $data['users'] = $userManager->getAll();
        $this->render(__DIR__ . '/../views/admin/users/manage_users.phtml', $data);
    }

    public function manageArticles()
    {
        $articleManager = new ArticleManager();
        $data['articles'] = $articleManager->getAll();
        $this->render(__DIR__ . '/../views/admin/articles/manage_articles.phtml', $data);
    }
}
