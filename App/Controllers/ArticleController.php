<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\ArticleManager;

class ArticleController extends Controller
{
    public function index()
    {
        $articleManager = new ArticleManager();
        $data['article'] = $articleManager->getAllActiveArticlesWithAuthors();
        $this->render(__DIR__ . '/../views/template_article.phtml', $data);
    }


    
}

