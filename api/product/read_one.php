<?php
/**
 * Created by PhpStorm.
 * User: Bra Emma
 * Date: 1/24/2019
 * Time: 2:50 PM
 */

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once "../../config/database.php";
include_once "../objects/product.php";

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

// set ID property of record to read
$product->product_id = isset($_GET['id']) ? $_GET['id'] : die();

$product->readOne();

if ($product->title != null) {
    $product_arr = array(
        "product_id"=> $product->product_id,
        "title"=> $product->title,
        "price"=> $product->price,
        "list_price"=> $product->list_price,
        "quantity"=> $product->quantity,
        "image"=> $product->image,
        "category_name"=> $product->category_name,
        "category_id"=> $product->c_id,
        "brand_name"=> $product->brand_name,
        "brand_id"=> $product->b_id,
        "description"=> $product->description,
        "keywords"=> $product->keywords,
        "sizes"=> $product->sizes,
        "color"=> $product->color,
        "memory"=> $product->memory,
        "tags"=> $product->tags,
        "included"=> $product->included,
        "features"=> $product->features
    );
    http_response_code(200);
    echo json_encode($product_arr);
}else{
    http_response_code(404);
    echo json_encode(array("message" => "Product does not exist."));
}