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

//include database and object files
include_once '../../config/database.php';
include_once '../objects/brands.php';

$database = new Database();
$db = $database->getConnection();

$brand = new Brands($db);

//get Posted data
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->name)) {

    //set property values
    $brand->name = $data->name;

    if ($brand->brand_name_exists()) {
        http_response_code(409);
        echo json_encode(array("message"=>"Brand Name already Exist"));
    }else{
        //create the brand
        if ($brand->create()) {
            // set response code - 201 created
            http_response_code(201);
            echo json_encode(array("message"=>"Brand Created Successfully"));
        } else {
            // set response code - 503 service unavailable
            http_response_code(503);
            echo json_encode(array("message"=>"Unable to create brand"));
        }
    }

} else {
    // set response code - 400 bad request
    http_response_code(400);
    echo json_encode(array("message"=>"Unable to create brand.... Incomplete data"));
}