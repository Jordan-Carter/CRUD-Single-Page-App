<?php
class Owner{

    // database connection and table name
    private $conn;
    private $table_name = "owners";
 
    // object properties
    public $id;
    public $fname;
    public $lname;
    public $street1;
    public $street2;
    public $city;
    public $state;
    public $zip;
    public $policy;
    public $expiration;
 
    public function __construct($db){
        $this->conn = $db;
    }

function read($pagenum, $perpage){
  
    $query = "SELECT id, fname, lname, street1, street2, city, state, zip, policy, expiration 
             FROM " . $this->table_name . "
             ORDER BY id DESC LIMIT ?, ?";
 
    $stmt = $this->conn->prepare($query);
    
    //WHERE fname LIKE ? 
    //$keywords=htmlspecialchars(strip_tags($keywords));
    //$keywords='"%%"';

    $val = $pagenum * $perpage;

    $stmt->bindParam(1, $val, PDO::PARAM_INT);
    $stmt->bindParam(2, $perpage, PDO::PARAM_INT);
   // $stmt->bindParam(3, $keywords);


    $stmt->execute();

    return $stmt;
}

function create(){
 
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
               fname = :fname, lname = :lname, street1 = :street1, street2 = :street2, city = :city, state = :state, zip = :zip, policy = :policy, expiration = :expiration";
 
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":fname", $this->fname);
    $stmt->bindParam(":lname", $this->lname);
    $stmt->bindParam(":street1", $this->street1);
    $stmt->bindParam(":street2", $this->street2);
    $stmt->bindParam(":city", $this->city);
    $stmt->bindParam(":state", $this->state);
    $stmt->bindParam(":zip", $this->zip);
    $stmt->bindParam(":policy", $this->policy);
    $stmt->bindParam(":expiration", $this->expiration);
 
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

function update(){
 
    $query = "UPDATE
    " . $this->table_name . "
            SET fname = :fname, lname = :lname, street1 = :street1, street2 = :street2, city = :city, state = :state, zip = :zip, policy = :policy, expiration = :expiration
            WHERE id = :id";
 
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":fname", $this->fname);
    $stmt->bindParam(":lname", $this->lname);
    $stmt->bindParam(":street1", $this->street1);
    $stmt->bindParam(":street2", $this->street2);
    $stmt->bindParam(":city", $this->city);
    $stmt->bindParam(":state", $this->state);
    $stmt->bindParam(":zip", $this->zip);
    $stmt->bindParam(":policy", $this->policy);
    $stmt->bindParam(":expiration", $this->expiration);
    $stmt->bindParam(":id", $this->id);
  
    if($stmt->execute()){
        return true;
    }
 
    return false;
}

function delete(){
 
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
 
    $stmt = $this->conn->prepare($query);
 
    $this->id=htmlspecialchars(strip_tags($this->id));
 
    $stmt->bindParam(1, $this->id);
 
    if($stmt->execute()){
        return true;
    }
    
    return false;
     
}

function readOne(){

    $query =  $query = "SELECT id, fname, lname, street1, street2, city, state, zip, policy, expiration 
    FROM " . $this->table_name . " WHERE id = ? LIMIT 1";
 
    $stmt = $this->conn->prepare( $query );
 
    $stmt->bindParam(1, $this->id);
 
    $stmt->execute();
 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    $this->fname = $row['fname'];
    $this->lname = $row['lname'];
    $this->street1 = $row['street1'];
    $this->street2 = $row['street2'];
    $this->city = $row['city'];
    $this->state = $row['state'];
    $this->zip = $row['zip'];
    $this->policy = $row['policy'];
    $this->expiration = $row['expiration'];
}

public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    return $row['total_rows'];
}

}