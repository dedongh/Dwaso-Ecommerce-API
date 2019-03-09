<?php
/**
 * Created by PhpStorm.
 * User: Bra Emma
 * Date: 1/19/2019
 * Time: 2:15 PM
 */
//₵
//required header
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database and object files
include_once '../../config/database.php';
include_once '../objects/brands.php';

//instantiate database and category object
$database = new Database();
$db = $database->getConnection();

//initialize object
$brands = new Brands($db);

//query brands
$stmt = $brands->read();
$num = $stmt->rowCount();

//check if more than 0 records found
if ($num > 0) {
    $brands_arr = array();
    $brands_arr["brands"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $brands_item = array(
            "id" => $b_id,
            "name" => $name
        );

        array_push($brands_arr["brands"], $brands_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show categories data in json format
    echo json_encode($brands_arr);
} else {
    // set response code - 404 Not found
    http_response_code(400);

    //nothing found
    echo json_encode(array("message" => "No brands found"));
}