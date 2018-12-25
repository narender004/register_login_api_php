<?php
class Users{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
    private $products = "products";
    private $category = "category";
    public $ID;
    public $username;
    public $email;
    public $contact;
    public $password;
    public $id;
    public $name;
    public $category_id;
    public $price;
    public $images;
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read users
function read(){
 
    // select all query
    $query = "SELECT * FROM " . $this->table_name; 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}
// used when filling up the update user form
function readOne(){ 
    // query to read single record
    $query = "SELECT *  FROM " . $this->table_name . " WHERE email=:email && password=:pass LIMIT 0,1"; 
    // prepare query statement
    
    $stmt = $this->conn->prepare( $query ); 
    $stmt->bindParam(":email", $this->email); 
    $stmt->bindParam(":pass", $this->pass); 
    // execute query
    $stmt->execute(); 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC); 
    // set values to object properties
    $this->id = $row['ID'];
    $this->username = $row['username'];
    $this->email = $row['email'];
    $this->contact = $row['contact'];
    $this->password = $row['password'];
    }
    // create user
function create(){ 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                username=:username, email=:email, password=:password, contact=:contact";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->username=htmlspecialchars(strip_tags($this->username));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->password=htmlspecialchars(strip_tags($this->password));
    $this->contact=htmlspecialchars(strip_tags($this->contact));    
    $this->password=md5($this->password);
    // bind values
    $stmt->bindParam(":username", $this->username);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":password", $this->password);
    $stmt->bindParam(":contact", $this->contact);
   
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
// delete the user
function delete(){
 
    // delete query
    print_r($this);
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
// update the product
function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,
                email = :email,
                password = :password,
                contact = :contact
            WHERE
                id = :id";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->password=htmlspecialchars(strip_tags($this->password));
    $this->contact=htmlspecialchars(strip_tags($this->contact));
    $this->id=htmlspecialchars(strip_tags($this->id));
 
    // bind new values
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':email', $this->email);
    $stmt->bindParam(':password', $this->password);
    $stmt->bindParam(':contact', $this->contact);
    $stmt->bindParam(':id', $this->id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
 
    return false;
}
// *************************Reset user password*********************
 function random_string()
{
    $character_set_array = array();
    $character_set_array[] = array('count' => 7, 'characters' => 'abcdefghijklmnopqrstuvwxyz');
    $character_set_array[] = array('count' => 1, 'characters' => '0123456789');
    $character_set_array[] = array('count' => 2, 'characters' => '@#$%^&*()_');
    $temp_array = array();
    foreach ($character_set_array as $character_set) {
        for ($i = 0; $i < $character_set['count']; $i++) {
            $temp_array[] = $character_set['characters'][rand(0, strlen($character_set['characters']) - 1)];
        }
    }
    shuffle($temp_array);
    return implode('', $temp_array);
}
  // * Check user is existed or not
 function isUserExisted($email) {
        $query = "SELECT email  FROM " . $this->table_name . " WHERE email= :email LIMIT 0,1";
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
        // bind id of user to be updated
        $this->email=htmlspecialchars(strip_tags($this->email));
        $stmt->bindParam(":email", $email);
        // / get retrieved row
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
         // echo "string".$this->username;       
        if (!empty($row['email'])) {
            // user existed 
            return true;
        } else {
            // user not existed
            return false;
        }
    }
     function forgotPassword($email, $newpassword, $salt)
 {
    $query = "UPDATE " . $this->table_name . " SET `password` = :password
                          WHERE `email` = :email";
 // prepare query statement
        // $salt=md5($salt);                  
        $stmt = $this->conn->prepare( $query );     
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $salt);
        // / get retrieved row
        // $stmt->execute();
        if ($stmt->execute()) 
        { 
       return true;
        }
        else
            {
                return false;
            }

}
   // * Encrypting password
   //   * returns salt and encrypted password
   //   */
    function hashSSHA($password) {

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
     //   * Decrypting password
     // * returns hash string
     // */
     function checkhashSSHA($salt, $password) {

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }
// ***************** End Reset user password*********************    
// Products################################################################################
       // read users
function read_products(){ 
    // select all query
    $query = "SELECT * FROM " . $this->products; 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}
function get_productby_id(){ 
    // query to read single record
    $query = "SELECT *  FROM " . $this->products . " WHERE id=:id LIMIT 0,1"; 
    // prepare query statement
    
    $stmt = $this->conn->prepare( $query ); 
    $stmt->bindParam(":id", $this->id);  
    // execute query
    $stmt->execute(); 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC); 
    // set values to object properties
    $this->id = $row['id'];
    $this->name = $row['name'];
    $this->category_id = $row['category_id'];
    $this->price = $row['price'];
    $this->images = $row['images'];
    }
}

?>