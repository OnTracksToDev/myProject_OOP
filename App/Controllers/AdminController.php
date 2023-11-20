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
        $data['article'] = $articleManager->getAllArticle();
        $data['user'] = $userManager->getAllUser();
        $data['byId'] = $userManager->getUserById(7);
        $this->render(__DIR__ . '/../views/admin/dashboard.phtml', $data);
    }
}
