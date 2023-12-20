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
        $data['article'] = $article->getAll(4);
        $data['caroussel'] = $article->getAll(3);
        $this->render(__DIR__ . '/../views/template_home.phtml', $data);
    }

}
