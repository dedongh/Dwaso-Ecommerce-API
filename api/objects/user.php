<?php
/**
 * Created by PhpStorm.
 * User: Bra Emma
 * Date: 1/19/2019
 * Time: 2:26 PM
 */

class User
{
    private $conn;
    private $table_name = "user_info";

    public $user_id;
    public $first_name;
    public $last_name;
    public $email;
    public $phone;
    public $password;
    public $hash;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    function create()
    {

    }

    function delete()
    {
        $query = "delete from ".$this->table_name." where uid = ?";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function update()
    {

    }

    function read_user_info()
    {

    }
}