<?php
namespace App\Controllers;
use App\Models\ArticleManager;
use App\Models\CommentManager;
use App\Controllers\Controller;
use App\Services\Authentication;

class DetailController extends Controller{

    public function __construct()
    {
        if (Authentication::isNotAllowed("ROLE_ADMIN")) { // revoir pour tous les roles
            header("Location:?page=login");
        }
    }

    public function index(){
        $id = intval($_GET['id']);
        
        $articleManager = new ArticleManager();
        $data['article'] = $articleManager->getActiveArticleById($id);

        $commentManager = new CommentManager();
        $data['comments']= $commentManager->getAllCommentsWithAuthorByArticle($id);

        $this->render(__DIR__ . '/../views/template_detail.phtml',$data);
    }

}

