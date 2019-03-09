<?php
/**
 * Created by PhpStorm.
 * User: Bra Emma
 * Date: 1/19/2019
 * Time: 2:25 PM
 */

class Category
{
    private $conn;
    private $table_name = "categories";

    public $id;
    public $name;
    public $description;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // read categories
    function read()
    {
        $query = "select c_id, name, description from ".$this->table_name. " order by name";
        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
    }

    // create categories
    function create()
    {
        $query = "insert into ".$this->table_name." 
        set name = :name, description = :description";
        $stmt = $this->conn->prepare($query);
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // delete category
    function delete()
    {
        $query = "delete from ".$this->table_name." where c_id = ?";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //update category
    function update()
    {
        $query = "update ".$this->table_name." 
        set name = :name,
        description = :description
         where c_id = :id";
        $stmt = $this->conn->prepare($query);
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function category_name_exist()
    {
        $query = "select name from ".$this->table_name. " where name = ?";
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));

        $stmt->bindParam(1, $this->name);
        $stmt->execute();

        $num = $stmt->rowCount();
        if ($num > 0) {
            return true;
        }
        return false;
    }
}