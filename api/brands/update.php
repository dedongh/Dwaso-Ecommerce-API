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
include_once "../objects/brands.php";

$database = new Database();
$db = $database->getConnection();

$brand = new Brands($db);

// get id of brand to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of brands to be edited
$brand->id = $data->id;

// set product property values
$brand->name = $data->name;

// update the brands
if ($brand->update()) {
    // set response code - 200 ok
    http_response_code(200);
    echo json_encode(array("message"=>"Brand was updated"));
} else {
    // set response code - 503 service unavailable
    http_response_code(503);
    echo json_encode(array("message"=>"Unable to update brand"));
}