<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\ArticleManager;
use App\Models\UserManager;

class HomeController extends Controller
{

    public function index()
    {
        $article = new ArticleManager();
        $data['article'] = $article->getAllArticle();
        $data['caroussel'] = $article->getRecentArticle(3);
        $this->render(__DIR__ . '/../views/template_home.phtml', $data);
    }

}
