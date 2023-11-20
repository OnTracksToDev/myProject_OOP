<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\CommentManager;

class CommentController extends Controller
{
    public function index()
    {
        $articleManager = new CommentManager();
    }

}
