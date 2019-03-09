<?php
/**
 * Created by PhpStorm.
 * User: Bra Emma
 * Date: 1/19/2019
 * Time: 2:14 PM
 */

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../../config/database.php";
include_once "../objects/category.php";

$database = new Database();
$db = $database->getConnection();

$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->name) && !empty($data->description)) {
    $category->name = $data->name;
    $category->description = $data->description;

    if ($category->category_name_exist()) {
        http_response_code(409);
        echo json_encode(array("message"=>"Category Name already Exist"));
    }else{
        if ($category->create()) {
            http_response_code(201);
            echo json_encode(array("message"=>"Category Created Successfully"));
        }else{
            http_response_code(503);
            echo json_encode(array("message"=>"Unable to create Category"));
        }
    }
}else{
    http_response_code(400);
    echo json_encode(array("message"=>"Unable to create Category.... Incomplete data"));
}