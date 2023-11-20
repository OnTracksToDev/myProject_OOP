<?php

namespace App\Services;

use PDO;
use PDOException;

require_once "../public/config.php";

class Database
{
    private $db_host;
    private $db_name;
    private $db_port;
    private $db_user;
    private $db_pass;
    private $db_dsn;
    private $pdo;

    public function __construct(
        $db_host = DB_HOST,
        $db_port = DB_PORT,
        $db_name = DB_NAME,
        $db_user = DB_USER,
        $db_pass = DB_PASS
    ) {
        $this->db_user = $db_user;
        $this->db_port = $db_port;
        $this->db_pass = $db_pass;
        $this->db_host = $db_host;
        $this->db_name = $db_name;
        $this->db_dsn = "mysql:host={$this->db_host};port={$this->db_port};dbname={$this->db_name};charset=utf8";
    }

    private function getPDO()
    {
        if ($this->pdo === null) {
            try {
                $this->pdo = new PDO($this->db_dsn, $this->db_user, $this->db_pass);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('PDO ne fonctionne pas' . $e->getMessage());
            }
        }

        return $this->pdo;
    }

    public function selectAll($statement, $params = [])
    {
        $stmt = $this->getPDO()->prepare($statement);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function select($statement, $params = [])
    {
        $stmt = $this->getPDO()->prepare($statement);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public function query($statement, $params = [])
    {
        $stmt = $this->getPDO()->prepare($statement);
        $stmt->execute($params);
        return $this->getPDO();
    }

public function count($query, $params = [])
{
    $stmt = $this->getPDO()->prepare($query);
    $stmt->execute($params);
    return $stmt->rowCount();
}

}
