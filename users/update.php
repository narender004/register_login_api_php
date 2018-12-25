<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/function.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$user = new Users($db);
 
// get id of user to be edited
// set ID property of user to be edited
$user->email = isset($_GET['email']) ? $_GET['email'] : die();
 
// read the details of user to be edited
$user->update();
// create array
$user_arr = array(
    "id" =>  $user->id,
    "username" => $user->username,
    "email" => $user->email,
    "password" => $user->password,
    "contact" => $user->contact    
);
 
// make it json format
print_r(json_encode($user_arr));
?>