<?php
/**
 * Created by PhpStorm.
 * User: Bra Emma
 * Date: 1/19/2019
 * Time: 2:15 PM
 */

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../../config/database.php";
include_once "../objects/brands.php";

$database = new Database();
$db = $database->getConnection();
$brand = new Brands($db);

$data = json_decode(file_get_contents("php://input"));

// set brand id to be deleted
$brand->id = $data->id;

if ($brand->delete()) {
    // set response code - 200 ok
    http_response_code(200);
    echo json_encode(array("message"=>"Brand was deleted"));
}else{
    // set response code - 503 service unavailable
    http_response_code(503);
    echo json_encode(array("message"=>"Unable to delete brand"));
}