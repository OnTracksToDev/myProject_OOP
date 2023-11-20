<?php

namespace App\Models;

use App\Services\Database;
use App\Models\AbstractManager;
use App\Models\User;

class UserManager extends AbstractManager
{

    public function __construct()
    {
        self::$db = new Database();
        self::$tableName = 'users';
        self::$obj = new User();
    }


    public function getAuthorNameByArticleId($articleId)
    {
        $query = "
            SELECT users.username as Author
            FROM users
            JOIN articles ON users.id = articles.user_id
            WHERE articles.id = ?
            LIMIT 1
        ";

        $result = self::$db->select($query, [$articleId]);
        return $result;
    }
    public function getUserByEmail($email = null): array|false
    {
        $whereEmail = !is_null($email) ? "WHERE email=?" : "";
        $row = [];
        $row = self::$db->select("SELECT * FROM ".self::$tableName." " . $whereEmail. "LIMIT 1", [$email]);
        return $row;
    }


}
