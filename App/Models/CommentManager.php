<?php

namespace App\Models;

use App\Services\Database;

class CommentManager
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

}
