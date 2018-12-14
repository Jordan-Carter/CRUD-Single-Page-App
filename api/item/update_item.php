<?php
include_once 'C:\xampp\htdocs\api\config\database.php';
include_once 'C:\xampp\htdocs\api\objects\items.php';
 
$database = new Database();
$db = $database->getConnection();
 
$item = new Item($db);
 
$data = json_decode(file_get_contents("php://input"));
 
$item->id = $data->id;

$item->name = $data->name;
$item->photo = $data->photo;
$item->description = $data->description;
$item->valuation = $data->valuation;
$item->method = $data->method;
$item->verified = $data->verified;
$item->creationDate = $data->creationDate;

 
if($item->update_item()){
 
    http_response_code(200);
 
    echo json_encode(array("message" => "item was updated."));
}
 
else{
 
    http_response_code(503);
 
    echo json_encode(array("message" => "Unable to update item."));
}
?>