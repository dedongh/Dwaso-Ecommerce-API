<?php
/**
 * Created by PhpStorm.
 * User: Bra Emma
 * Date: 1/19/2019
 * Time: 1:16 PM
 */

//show error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//home page url
$home_url = "http://localhost/projects/dwaso/";

$page = isset($_GET["page"]) ? $_GET["page"] : 1;

//set number of records per page
$records_per_page = 1;

//calculate for the query limit clause
$from_record_num = ($records_per_page * $page) - $records_per_page;
