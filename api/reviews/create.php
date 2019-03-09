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
include_once '../objects/review.php';

$database = new Database();
$db = $database->getConnection();

$review = new Review($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->user_id) && !empty($data->subject) && !empty($data->review) &&
    !empty($data->rating) && !empty($data->product_id)) {

    $review->user_id = $data->user_id;
    $review->subject = $data->subject;
    $review->review = $data->review;
    $review->rating = $data->rating;
    $review->product_id = $data->product_id;

    if ($review->create()) {
        http_response_code(201);
        echo json_encode(array("message"=>"Review Submitted awaiting approval"));

    }else{
        http_response_code(503);
        echo json_encode(array("message"=>"Unable to create review"));
    }
}else{
    http_response_code(400);
    echo json_encode(array("message"=>"Unable to Review product.... Incomplete data"));
}