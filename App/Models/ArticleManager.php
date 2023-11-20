<?php

namespace App\Models;

use App\Services\Database;

class ArticleManager
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllArticle($limit = null)
    {
        $limitIs = !is_null($limit) ? "LIMIT " . $limit : "";
        $query = "SELECT * FROM articles 
            JOIN users ON articles.user_id = users.id
            ORDER BY articles.id DESC" . $limitIs;

        return $this->db->selectAll($query);
    }

    public function getArticleById($id = null)
    {
        $whereIs = !is_null($id) ? "WHERE articles.id=?" : "";
        $query = "SELECT * FROM articles 
            JOIN users ON articles.user_id = users.id {$whereIs} LIMIT 1";

        return $this->db->select($query, [$id]);
    }

    public function createArticle($data = [])
    {
        $query = "INSERT INTO articles (title, content, imagePath, id) VALUES (?,?,?,?)";
        return $this->db->query($query, $data);
    }

    public function deleteArticle($id = null)
    {
        if (!is_null($id)) {
            $query = "DELETE FROM articles WHERE id=?";
            $this->db->query($query, [$id]);
            return true;
        }

        return false;
    }

    public function updateArticle($id, $imagePath, $title, $content, $user_id)
    {
        if (!is_null($id)) {
            $query = "UPDATE articles SET imagePath=?, title=?, content=?, user_id=? WHERE id=?";
            $params = [$imagePath, $title, $content, $user_id, $id];

            return $this->db->query($query, $params);
        }

        return false;
    }

    public function getRecentArticle($limit = null)
    {
        $limitIs = !is_null($limit) ? " LIMIT " . $limit : "";
        $query = "SELECT * FROM articles 
            JOIN users ON articles.user_id = users.id
            ORDER BY articles.id DESC" . $limitIs;
    
        return $this->db->selectAll($query);
    }
            


    public function countAllArticle()
    {
        $query = "SELECT * FROM articles 
            JOIN users ON articles.user_id = users.id";

        return $this->db->count($query);
    }
}
