<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object file
include_once '../config/database.php';
include_once '../objects/function.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection(); 
// prepare user object
$user = new Users($db); 
// get user id
$data = json_decode(file_get_contents("php://input"));
// set user id to be deleted
$email = $data->email;
if($email!=""){
$randomcode = $user->random_string(); 
$hash = $user->hashSSHA($randomcode);
$encrypted_password = $hash["encrypted"];// encrypted password
$salt = $hash["salt"];
$subject = "Password Recovery";
$message = "Hello User,\n\nYour Password is sucessfully changed. Your new Password is $randomcode . Login with your new Password and change it in the User Panel.\n\nRegards,\nLearn2Crack Team.";
$from = "vikas479sharma@gmail.com";
$headers = "From:" . $from;
if ($user->isUserExisted($email)) 
  {
    $user = $user->forgotPassword($email, $encrypted_password, $salt);
    if ($user) 
{
         $response["success"] = 1;
          mail($email,$subject,$message,$headers);
         echo json_encode($response);
}
else {
$response["error"] = 1;
echo json_encode($response);
} // user is already existed - error response         
} 
 else
  { 
    $response["error"] = 2;
    $response["error_msg"] = "User not exist";
    echo json_encode($response);
} 
}
else{
    echo json_encode(
        array("message" => "No Access")
    );
}
?>