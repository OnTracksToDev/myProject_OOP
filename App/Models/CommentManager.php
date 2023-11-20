<?php

namespace App\Models;

use App\Services\Database;
use App\Models\AbstractManager;
use App\Models\Comment;

class CommentManager extends AbstractManager
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

}
