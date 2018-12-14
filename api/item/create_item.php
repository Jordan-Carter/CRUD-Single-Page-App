<?php
include_once 'C:\xampp\htdocs\api\config\database.php';
include_once 'C:\xampp\htdocs\api\objects\items.php';
 
$database = new Database();
$db = $database->getConnection();
 
$item = new Item($db);
 
$key = isset($_GET['ownerkey']) ? $_GET['ownerkey'] : die();
$data = json_decode(file_get_contents("php://input"));
 
if(
    !is_null($data->name) &&
    !is_null($data->photo) &&
    !is_null($data->description) &&
    !is_null($data->valuation) &&
    !is_null($data->method) &&
    !is_null($data->verified) &&
    !is_null($data->creationDate)
){
 
    $item->name = $data->name;
    $item->photo = $data->photo;
    $item->description = $data->description;
    $item->valuation = $data->valuation;
    $item->method = $data->method;
    $item->verified = $data->verified;
    $item->creationDate = $data->creationDate;


    if($item->create_item($key)){
 
        http_response_code(201);
 
        echo json_encode(array("message" => "Item was created."));
    }
 
    else{
 
        http_response_code(503);
 
        echo json_encode(array("message" => "Unable to create item."));
    }
}
 
else{
 
    http_response_code(400);
 
    echo json_encode(array("message" => "Unable to create item. Data is incomplete."));
}
?>