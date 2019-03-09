<?php
/**
 * Created by PhpStorm.
 * User: Bra Emma
 * Date: 1/19/2019
 * Time: 2:25 PM
 */

class Product
{
    private $conn;
    private $table_name = "products";

    public $title;
    public $price;
    public $list_price;
    public $b_id;
    public $c_id;
    public $image;
    public $description;
    public $quantity;
    public $keywords;
    public $sizes;
    public $color;
    public $memory;
    public $tags;
    public $included;
    public $features;
    public $category_name;
    public $brand_name;
    public $product_id;
    public function __construct($db)
    {
        $this->conn = $db;
    }

    //read all products
    function read()
    {
        $query = "select b.name as brand_name, b.b_id as brand_id, c.name as category_name, c.c_id as category_id,
          p.p_id as product_id, p.title, p.price, p.list_price, p.quantity, p.description, p.image,
       p.color, p.memory, p.tags, p.sizes, p.features, p.included as in_the_box, p.keywords from products p
          LEFT JOIN categories c
          ON c.c_id = p.c_id
          LEFT JOIN brands b
          ON b.b_id = p.b_id
          where p.deleted = 0
          ORDER by p.p_id DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    //read one product
     function readOne()
    {
        $query = "select b.name as brand_name, b.b_id as brand_id, c.name as category_name, c.c_id as category_id,
          p.p_id as product_id, p.title, p.price, p.list_price, p.quantity, p.description, p.image,
       p.color, p.memory, p.tags, p.sizes, p.features, p.included as in_the_box, p.keywords from products p
          LEFT JOIN categories c
          ON c.c_id = p.c_id
          LEFT JOIN brands b
          ON b.b_id = p.b_id
          where p.p_id = ? and p.deleted = 0 limit 0,1
";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->product_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->title = $row["title"];
        $this->price = $row["price"];
        $this->list_price = $row["list_price"];
        $this->b_id = $row["brand_id"];
        $this->brand_name = $row["brand_name"];
        $this->c_id = $row["category_id"];
        $this->category_name = $row["category_name"];
        $this->quantity = $row["quantity"];
        $this->description = $row["description"];
        $this->image = $row["image"];
        $this->color = $row["color"];
        $this->memory = $row["memory"];
        $this->tags = $row["tags"];
        $this->sizes = $row["sizes"];
        $this->features = $row["features"];
        $this->included = $row["in_the_box"];
        $this->keywords = $row["keywords"];
    }

    // search for a product
    function search($keywords)
    {
        $search_exploded = explode(" ", $keywords);
        $x = 0;
        $query = " ";
        foreach ($search_exploded as $search_each) {
            $x++;
            if ($x == 1) {
                $query .= "title like '%$search_each%'";
            }else{
                $query .= "and title like '%$search_each%'";
            }
            $query = "select b.name as brand_name, b.b_id as brand_id, c.name as category_name, c.c_id as category_id,
          p.p_id as product_id, p.title, p.price, p.list_price, p.quantity, p.description, p.image,
       p.color, p.memory, p.tags, p.sizes, p.features, p.included as in_the_box, p.keywords from products p
          LEFT JOIN categories c
          ON c.c_id = p.c_id
          LEFT JOIN brands b
          ON b.b_id = p.b_id
          where $query and deleted = 0";
            $stmt = $this->conn->prepare($query);

            $stmt->execute();
            return $stmt;
        }
    }

    //read products with pagination
    public function readPaging($from_record_num, $records_per_page)
    {
        $query = "select b.name as brand_name, b.b_id as brand_id, c.name as category_name, c.c_id as category_id,
          p.p_id as product_id, p.title, p.price, p.list_price, p.quantity, p.description, p.image,
       p.color, p.memory, p.tags, p.sizes, p.features, p.included as in_the_box, p.keywords from products p
          LEFT JOIN categories c
          ON c.c_id = p.c_id
          LEFT JOIN brands b
          ON b.b_id = p.b_id
          where p.deleted = 0
          ORDER by p.p_id DESC
          limit ?,?";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt;
    }

    public function count()
    {
        $query = "select count(*) as total_rows from ".$this->table_name;
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }
}