<?php
/**
 * Created by PhpStorm.
 * User: Bra Emma
 * Date: 1/19/2019
 * Time: 2:25 PM
 */

class Brands
{

    private $conn;
    private $table_name = "brands";

    //object properties
    public $id;
    public $name;
   // public $image;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    //read brands
    function read()
    {
        $query = "select b_id, name from ". $this->table_name. " order by name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    //add brands
    function create()
    {
        $query = "Insert into ".$this->table_name." Set name = :name";
        $stmt = $this->conn->prepare($query);

        //sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));

        //bind param
        $stmt->bindParam(":name", $this->name);
        //$stmt->bindParam(":image", $this->image);

        //execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;

    }

    // delete brands
    function delete()
    {
        $query = " delete from ".$this->table_name. " where b_id = ?";
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function update()
    {
        $query = "update ".$this->table_name. "
        SET name = :name 
        where b_id = :id";

        $stmt = $this->conn->prepare($query);
        //sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":id", $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function brand_name_exists()
    {
        $query = "select name from " . $this->table_name . " where name = ?";
        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));

        $stmt->bindParam(1, $this->name);

        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // if access_code exists
        if($num > 0){
            // return true because brand exists in the database
            return true;
        }
        // return false if brand does not exist in the database
        return false;
    }
}