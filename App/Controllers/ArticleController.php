<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\ArticleManager;

class ArticleController extends Controller
{
    public function index()
    {
        $articleManager = new ArticleManager();
        $data['article'] = $articleManager->getAllArticle();
        $this->render('./views/template_home.phtml', [$data]);
    }


    
}

