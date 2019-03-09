<?php
/**
 * Created by PhpStorm.
 * User: Bra Emma
 * Date: 1/19/2019
 * Time: 2:14 PM
 */

include_once "../../config/database.php";
include_once "../objects/category.php";

$database = new Database();
$db = $database->getConnection();
$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

$category->id = $data->id;
$category->name = $data->name;
$category->description = $data->description;

if ($category->category_name_exist()) {
    http_response_code(409);
    echo json_encode(array("message"=>"Category Name already Exist"));
}else{
    if ($category->update()) {
        http_response_code(200);
        echo json_encode(array("message"=>"Category was updated"));
    }else{
        http_response_code(503);
        echo json_encode(array("message"=>"Unable to update Category"));
    }
}