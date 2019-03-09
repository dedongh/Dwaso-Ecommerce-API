<?php
/**
 * Created by PhpStorm.
 * User: Bra Emma
 * Date: 1/19/2019
 * Time: 2:15 PM
 */

include_once "../../config/database.php";
include_once "../objects/category.php";

$database = new Database();
$db = $database->getConnection();

$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

$category->id = $data->id;
if ($category->delete()) {
    http_response_code(200);
    echo json_encode(array("message"=>"Category was deleted"));
}else{
    http_response_code(503);
    echo json_encode(array("message"=>"Unable to delete category"));
}