<?php
/**
 * Created by PhpStorm.
 * User: Bra Emma
 * Date: 1/25/2019
 * Time: 3:17 PM
 */

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../../config/core.php';
include_once '../shared/util.php';
include_once '../../config/database.php';
include_once '../objects/product.php';

$utilities = new Util();
$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$stmt = $product->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();

if ($num > 0) {
    $products_arr=array();
    $products_arr["products"] = array();
    $products_arr["paging"]=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $product_item = array(
            "product_id"=> $product_id,
            "title"=> $title,
            "price"=> $price,
            "list_price"=> $list_price,
            "quantity"=> $quantity,
            "image"=> $image,
            "category_name"=> $category_name,
            "category_id"=> $category_id,
            "brand_name"=> $brand_name,
            "brand_id"=> $brand_id,
            "description"=> $description,
            "keywords"=> $keywords,
            "sizes"=> $sizes,
            "color"=> $color,
            "memory"=> $memory,
            "tags"=> $tags,
            "included"=> $in_the_box,
            "features"=> $features
        );
        array_push($products_arr["products"], $product_item);
    }
    // include paging
    $total_rows = $product->count();
    $page_url = "{$home_url}product/read_paging.php?";
    $paging = $utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $products_arr["paging"] = $paging;

    http_response_code(200);
    echo json_encode($products_arr);
}else{
    http_response_code(404);
    echo json_encode(
        array("message" => "No products found.")
    );
}
