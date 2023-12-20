<?php

namespace App\Models;

use App\Services\Database;
use App\Models\AbstractManager;
use App\Models\Comment;

class CommentManager extends AbstractManager
{

    public function __construct()
    {
        self::$db = new Database();
        self::$tableName = 'comments';
        self::$obj = new Comment();
    }
    public function getAllActiveCommentsWithAuthors($nb = null): array|false
    {
        $query = " 
        SELECT
        *,
        comments.content AS commentContent
        FROM users
        JOIN comments ON comments.user_id = users.id
        JOIN articles ON articles.user_id = users.id
        WHERE comments.isActive = 1
        ";
        $result = self::$db->selectAll($query);
        return $result;
    }
    public function getAllCommentsWithAuthorByArticle($articleID)
    {
        $query = "
        SELECT
        comments.*,
        users.username As username,
        users.profile_image_path AS profile_img
        FROM comments
        JOIN users ON comments.user_id = users.id
        JOIN articles ON articles.id = comments.article_id
        WHERE comments.article_id = ?;
        ";

        $result = self::$db->selectAll($query, [$articleID]);
        return $result;
    }

    public function softDeleteComment($commentId)
    {
        // Soft delete the article
        $queryComment = "UPDATE comments SET deleted_at = NOW(), isActive = FALSE WHERE id = ?";
        $result = self::$db->query($queryComment, [$commentId]);

        return $result;
    }
}
