<?php
/**
 * Created by PhpStorm.
 * User: Bra Emma
 * Date: 1/19/2019
 * Time: 2:15 PM
 */
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once "../../config/database.php";
include_once "../objects/review.php";

$database = new Database();
$db = $database->getConnection();

$review = new Review($db);

// set ID property of record to read
$review->product_id = isset($_GET["id"]) ? $_GET["id"] : die();
$stmt = $review->read_product_review();
$num = $stmt->rowCount();
if ($num > 0) {
    $review_arr = array();
    $review_arr["reviews"] = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $review_item = array(
            "id" => $id,
            "user_id" => $uid,
            "subject" => $subject,
            "review" => $review,
            "rating" => $rating,
            "product_id" => $p_id
        );
        array_push($review_arr["reviews"], $review_item);
    }
    http_response_code(200);
    echo json_encode($review_arr);
}else{
    http_response_code(400);
    echo json_encode(array("message"=>"No review for this product"));
}