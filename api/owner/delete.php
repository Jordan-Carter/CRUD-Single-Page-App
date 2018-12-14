<?php
include_once 'C:\xampp\htdocs\api\config\database.php';
include_once 'C:\xampp\htdocs\api\objects\owners.php';
 
$database = new Database();
$db = $database->getConnection();
 
$owner = new Owner($db);
 
$data = json_decode(file_get_contents("php://input"));
 
$owner->id = $data->id;
 
if($owner->delete()){
 
    http_response_code(200);
 
    echo json_encode(array("message" => "Owner was deleted."));
}
 
else{
 
    http_response_code(503);
 
    echo json_encode(array("message" => "Unable to delete owner."));
}
?>