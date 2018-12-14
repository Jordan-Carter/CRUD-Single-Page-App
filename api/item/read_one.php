<?php
include_once 'C:\xampp\htdocs\api\config\database.php';
include_once 'C:\xampp\htdocs\api\objects\items.php';
 
$database = new Database();
$db = $database->getConnection();
 
$item = new Item($db);
 
$item->id = isset($_GET['id']) ? $_GET['id'] : die();
 
$item->readOne();
 
if($item->id!=null){
    $item_arr = array(
        "id" => $item->id,
        "name" => $item->name,
        "photo" => $item->photo,
        "description" => $item->description,
        "valuation" => $item->valuation,
        "method" => $item->method,
        "verified" => $item->verified,
        "creationDate" => $item->creationDate
    );
 
    http_response_code(200);
 
    echo json_encode($item_arr);
}
 
else{

    http_response_code(404);
 
    echo json_encode(array("message" => "item does not exist."));
}
?>