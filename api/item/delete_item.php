<?php
include_once 'C:\xampp\htdocs\api\config\database.php';
include_once 'C:\xampp\htdocs\api\objects\items.php';
 
$database = new Database();
$db = $database->getConnection();
 
$item = new Item($db);
 
$data = json_decode(file_get_contents("php://input"));
 
$item->id = $data->id;
 
if($item->delete_item()){
 
    http_response_code(200);
 
    echo json_encode(array("message" => "item was deleted."));
}
 
else{
 
    http_response_code(503);
 
    echo json_encode(array("message" => "Unable to delete item."));
}
?>