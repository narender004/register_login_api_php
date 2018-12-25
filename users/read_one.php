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
$user->email = $_GET['email'];
$user->pass = urldecode($_GET['pass']);
 

 
// read the details of user to be edited
$user->readOne(); 
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