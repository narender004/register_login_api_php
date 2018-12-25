<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/function.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$user = new Users($db);
 
// set ID property of user to be edited
$user->id = $_GET['id']; 
// read the details of user to be edited
$product->get_productby_id(); 
// create array
$user_arr = array(
    "id" =>  $product->id,
    "name" => $product->name,
    "category_id" => $product->category_id,
    "price" => $product->price,
    "images" => $product->images    
);
 
// make it json format
print_r(json_encode($user_arr));
?>
