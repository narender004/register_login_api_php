<?php
class Users{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties
    public $ID;
    public $username;
    public $email;
    public $contact;
    public $password;
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
    $query = "SELECT *  FROM " . $this->table_name . " WHERE ID= ? LIMIT 0,1"; 
    // prepare query statement
    $stmt = $this->conn->prepare( $query ); 
    // bind id of user to be updated
    $stmt->bindParam(1, $this->id); 
    // execute query
    $stmt->execute(); 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC); 
    // set values to object properties
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
                username=:username, email=:email, password=:password, contact=:contact, created=:created";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->username=htmlspecialchars(strip_tags($this->username));
    $this->email=htmlspecialchars(strip_tags($this->email));
    $this->password=htmlspecialchars(strip_tags($this->password));
    $this->contact=htmlspecialchars(strip_tags($this->contact));
    $this->created=htmlspecialchars(strip_tags($this->created));
 
    // bind values
    $stmt->bindParam(":username", $this->username);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":password", $this->password);
    $stmt->bindParam(":contact", $this->contact);
    $stmt->bindParam(":created", $this->created);
 
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
     if($stmt->rowCount())
    {
        return true;
    }
 
    return false;
     
}
// update the product
function update(){ 
      // query to read single record
    $query = "SELECT *  FROM " . $this->table_name . " WHERE email= ? LIMIT 0,1"; 
    // prepare query statement
    $stmt = $this->conn->prepare( $query ); 
    // bind id of user to be updated
    $stmt->bindParam(1, $this->email); 
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
}
?>