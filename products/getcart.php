
<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/function.php';
 
// instantiate database and user object
$database = new Database();
$db = $database->getConnection();
$ID="";
 
// initialize object
$user = new Users($db);
 
// query users
$stmt = $user->read_products();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // users array
    $users_arr=array();
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only        
        $users_arr[]=$row;
    } 
    //echo json_encode($users_arr);

   echo "[{ \"product_id\": \"1\", \"category_id\": \"1\", \"category_name\": \"breakfast\", \"product_name\": \"LASAL CHEESE\", \"price\": \"80\", \"images\": \"http://192.168.1.5/api/products/images/img3.png\", \"images1\": \"http://192.168.1.5/api/products/images/img3.png\", \"images2\": \"http://192.168.1.5/api/products/images/img3.png\", \"detail\": \"this product is very good\", \"quantity\": \"2\" }]";


}
 
else{
    echo json_encode(
        array("message" => "No users found.")
    );
}
?>