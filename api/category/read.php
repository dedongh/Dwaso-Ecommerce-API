<?php
/**
 * Created by PhpStorm.
 * User: Bra Emma
 * Date: 1/19/2019
 * Time: 2:15 PM
 */

//required header
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../../config/database.php";
include_once "../objects/category.php";

//instantiate database and category object
$database = new Database();
$db = $database->getConnection();

$category = new Category($db);

$stmt = $category->read();
$num = $stmt->rowCount();

if ($num > 0) {
    $category_arr = array();
    $category_arr["category"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $category_item = array(
            "id"=> $c_id,
            "name"=> $name,
            "description"=> $description
        );
    }
}else{
    http_response_code(400);
    echo json_encode(array("message"=>"No categories found "));
}