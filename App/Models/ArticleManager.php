<?php

namespace App\Models;

use App\Services\Database;
use App\Models\AbstractManager;
use App\Models\Article;

class ArticleManager extends AbstractManager
{

    public function __construct()
    {
        self::$db = new Database();
        self::$tableName = 'articles';
        self::$obj = new Article();
    }
            
}
