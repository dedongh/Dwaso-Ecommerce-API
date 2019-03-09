<?php
/**
 * Created by PhpStorm.
 * User: Bra Emma
 * Date: 1/19/2019
 * Time: 2:27 PM
 */

class Review{

    private $conn;
    private $table_name = "reviews";
    public $id;
    public $user_id;
    public $subject;
    public $rating;
    public $review;
    public $product_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function read_product_review()
    {
        $query = "select 
                  id, uid, subject, rating, review, p_id from "
            .$this->table_name." where p_id = ? 
            and status = 1 order by id desc";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->product_id);
        $stmt->execute();

        return $stmt;
    }

    function create()
    {
        $query = "insert into ".$this->table_name.
            " set  
            uid = :uid,
            subject = :subject,
            review = :review,
            rating = :rating,
            p_id = :p_id
            ";

        $stmt = $this->conn->prepare($query);

        $this->subject = htmlspecialchars(strip_tags($this->subject));
        $this->review = htmlspecialchars(strip_tags($this->review));

        $stmt->bindParam(":uid", $this->user_id);
        $stmt->bindParam(":subject", $this->subject);
        $stmt->bindParam(":review", $this->review);
        $stmt->bindParam(":rating", $this->rating);
        $stmt->bindParam(":p_id", $this->product_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function delete()
    {
        $query = "delete from ".$this->table_name." where id = ?";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


}