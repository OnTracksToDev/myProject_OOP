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
        $row = self::$db->select("SELECT * FROM " . self::$tableName . " " . $whereEmail . "LIMIT 1", [$email]);
        return $row;
    }


    public function getAllCommentsByUser($userID)
    {
        $query = "
        SELECT *
        FROM users
        JOIN comments ON comments.user_id = users.id
        JOIN articles ON articles.id = comments.article_id
        WHERE users.id = ?
        ";

        $result = self::$db->selectAll($query, [$userID]);
        return $result;
    }
    public function getAllArticlesByUser($userID)
    {
        $query = "
        SELECT *
            FROM users
            JOIN articles ON articles.user_id = users.id
            WHERE users.id =? 
        ";

        $result = self::$db->selectAll($query, [$userID]);
        return $result;
    }
    public function getAllActiveUsers($nb = null): array|false
    {
        $limit = !is_null($nb) ? "LIMIT " . $nb : "";
        $results = self::$db->selectAll("SELECT * FROM " . self::$tableName . " WHERE users.isActive = 1 ORDER BY id DESC " . $limit);
        return $results;
    }


    public function softDeleteUser($userId)
    {
        // Archive articles
        $queryArticles = "UPDATE articles SET deleted_at = NOW(), isActive = FALSE WHERE user_id = ?";
        self::$db->query($queryArticles, [$userId]);

        // Archive comments made by the user
        $queryCommentsUser = "UPDATE comments SET deleted_at = NOW(), isActive = FALSE WHERE user_id = ?";
        self::$db->query($queryCommentsUser, [$userId]);

        // Archive comments made by other users on articles of the user
        $queryCommentsOthers = "UPDATE comments SET deleted_at = NOW(), isActive = FALSE WHERE article_id IN (SELECT id FROM articles WHERE user_id = ?) AND user_id != ?";
        self::$db->query($queryCommentsOthers, [$userId, $userId]);

        // Soft delete the user
        $queryUser = "UPDATE users SET deleted_at = NOW(), isActive = FALSE WHERE id = ?";
        $result = self::$db->query($queryUser, [$userId]);

        return $result;
    }
}
