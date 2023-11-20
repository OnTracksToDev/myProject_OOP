<?php

namespace App\Models;

use App\Services\Database;

class UserManager
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllUser($limit = null)
    {
        $limitIs = !is_null($limit) ? "LIMIT" . $limit : "";
        $query = "SELECT * FROM users 
           LEFT JOIN articles ON users.id = articles.user_id
            ORDER BY users.id DESC" . $limitIs;

        return $this->db->selectAll($query);
    }

    public function getUserById($id = null)

    {
        $whereIs = !is_null($id) ? "WHERE users.id=?" : "";
        //diférencier l'id de users.id avec l'id de l'article
        $query = "SELECT users.id, users.username, users.email, users.password, users.role, users.profile_image_path, users.date_register,
              articles.id AS article_id, articles.title, articles.content, articles.user_id AS article_user_id, articles.image_path, articles.date_publication
              FROM users
              LEFT JOIN articles ON users.id = articles.user_id
              {$whereIs}
              LIMIT 1";
        return $this->db->select($query, [$id]);
    }



    public function getUserByMail($mail = null)
    {
        $whereIs = !is_null($mail) ? "WHERE users.email=?" : "";
        $query =
            "SELECT 
              users.id, 
              users.username, 
              users.password,
              users.email, 
              users.role, 
              users.profile_image_path, 
              users.date_register,
              articles.id AS article_id, 
              articles.title, 
              articles.content, 
              articles.user_id AS article_user_id, 
              articles.image_path, 
              articles.date_publication
              FROM users
              LEFT JOIN articles ON users.id = articles.user_id
              {$whereIs}
              LIMIT 1";


        return $this->db->select($query, [$mail]);
    }




    public function createUser($data = [])
    {
        $query = "INSERT INTO users (username, email, password) VALUES (?,?,?)";
        return $this->db->query($query, $data);
    }


    public function deleteUser($id = null)
    {
        if (!is_null($id)) {
            $query = "DELETE FROM users WHERE id=?";
            $this->db->query($query, [$id]);
            return true;
        }

        return false;
    }
    public function updateUser($id, $username, $email, $password)
    {
        if (!is_null($id)) {
            $query = "UPDATE users SET username=?, email=?, password=? WHERE id=?";
            $params = [$username, $email, $password, $id];

            return $this->db->query($query, $params);
        }

        return false;
    }
    public function countAllUser()
    {
        $query = "SELECT * FROM users 
            JOIN articles ON users.id = articles.user_id";

        return $this->db->count($query);
    }
}
