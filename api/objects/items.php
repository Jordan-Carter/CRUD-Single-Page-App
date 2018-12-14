<?php
class Item{

    // database connection and table name
    private $conn;
    private $table_name = "items";
 
    // object properties
    public $id;
    public $name;
    public $photo;
    public $description;
    public $valuation;
    public $method;
    public $verified;
    public $creationDate;
 
    public function __construct($db){
        $this->conn = $db;
    }

function read_items($ownerkey){
  
    $query = "SELECT items.* 
    FROM items
    INNER JOIN owneritems ON items.id = owneritems.itemKey
    WHERE owneritems.ownerKey = ?";
    
 
    $stmt = $this->conn->prepare($query);
    
    $stmt->bindParam(1, $ownerkey);

    $stmt->execute();

    return $stmt;
}

function create_item($ownerkey)
{
    $query = "INSERT INTO
                " . $this->table_name . "
            SET name = :name, photo = :photo, description = :description, valuation = :valuation, method = :method, verified = :verified, creationDate = :creationDate;
               INSERT INTO owneritems
               SET owneritems.ownerkey = :ownerkey, owneritems.itemkey = LAST_INSERT_ID()";
 
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":photo", $this->photo);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":valuation", $this->valuation);
    $stmt->bindParam(":method", $this->method);
    $stmt->bindParam(":verified", $this->verified);
    $stmt->bindParam(":creationDate", $this->creationDate);
    $stmt->bindParam(":ownerkey", $ownerkey);
 
    if($stmt->execute()){
        return true;
    }
 
    return false;
}

function delete_item(){
 
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?; DELETE FROM owneritems WHERE owneritems.itemKey = ?";
 
    $stmt = $this->conn->prepare($query);
 
    $this->id=htmlspecialchars(strip_tags($this->id));
 
    $stmt->bindParam(1, $this->id);
    $stmt->bindParam(2, $this->id);
 
    if($stmt->execute()){
        return true;
    }
    
    return false;    
}

function update_item(){

    $query = "UPDATE
    " . $this->table_name . "
            SET name = :name, photo = :photo, description = :description, valuation = :valuation, method = :method, verified = :verified, creationDate = :creationDate
            WHERE id = :id";
 
    $stmt = $this->conn->prepare($query);
 
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":photo", $this->photo);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":valuation", $this->valuation);
    $stmt->bindParam(":method", $this->method);
    $stmt->bindParam(":verified", $this->verified);
    $stmt->bindParam(":creationDate", $this->creationDate);
    $stmt->bindParam(":id", $this->id);
    
    if($stmt->execute()){
        return true;
    }
 
    return false;
}

function readOne(){

    $query ="SELECT id, name, photo, description, valuation, method, verified, creationDate
    FROM " . $this->table_name . " WHERE id = ? LIMIT 1";
 
    $stmt = $this->conn->prepare( $query );
 
    $stmt->bindParam(1, $this->id);
 
    $stmt->execute();
 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    $this->name = $row['name'];
    $this->photo = $row['photo'];
    $this->description = $row['description'];
    $this->valuation = $row['valuation'];
    $this->method = $row['method'];
    $this->verified = $row['verified'];
    $this->creationDate = $row['creationDate'];
}

}