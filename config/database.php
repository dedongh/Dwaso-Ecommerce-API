<?php
/**
 * Created by PhpStorm.
 * User: Bra Emma
 * Date: 1/19/2019
 * Time: 12:59 PM
 */

class Database
{
    //specify your database credentials
    private $host = "localhost";
    private $db_name = "giloo";
    private $username = "engineerskasa";
    private $password = '$eng$kasa';

    public $conn;

    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db_name,
            $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: ".$exception->getMessage();
        }
        return $this->conn;
    }
}