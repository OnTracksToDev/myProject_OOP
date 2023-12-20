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

    public function getAllActiveArticlesWithAuthors($nb = null): array|false
    {
        $query = "
        SELECT *
        FROM users
        JOIN articles ON articles.user_id = users.id
        WHERE articles.isActive = 1
    ";
        $result = self::$db->selectAll($query);
        return $result;
    }


    public function getActiveArticleById($id = null): array | false
    {
        $whereId = !is_null($id) ? "WHERE " . self::$tableName . ".id=? AND " . self::$tableName . ".isActive=1" : "WHERE " . self::$tableName . ".isActive=1";
        $row = [];
        $query = "SELECT *, users.* 
                  FROM " . self::$tableName . "
                  LEFT JOIN users ON " . self::$tableName . ".user_id = users.id
                  " . $whereId . " LIMIT 1";
        $row = self::$db->select($query, [$id]);
        return $row;
    }

    public function softDeleteArticle($articleId)
    {
        // Archive comments related to the article
        $queryCommentsArticle = "UPDATE comments SET deleted_at = NOW(), isActive = FALSE WHERE article_id = ?";
        self::$db->query($queryCommentsArticle, [$articleId]);

        // Soft delete the article
        $queryArticle = "UPDATE articles SET deleted_at = NOW(), isActive = FALSE WHERE id = ?";
        $result = self::$db->query($queryArticle, [$articleId]);

        return $result;
    }
}
