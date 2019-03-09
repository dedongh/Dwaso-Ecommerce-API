<?php
/**
 * Created by PhpStorm.
 * User: Bra Emma
 * Date: 1/19/2019
 * Time: 2:27 PM
 */

class Wishlist
{
    private $conn;
    private $table_name = "wishlist";
    public function __construct($db)
    {
        $this->conn = $db;
    }
}