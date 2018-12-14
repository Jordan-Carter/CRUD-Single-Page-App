<?php
include_once 'C:\xampp\htdocs\api\config\database.php';
include_once 'C:\xampp\htdocs\api\objects\owners.php';
 
$database = new Database();
$db = $database->getConnection();
 
$owner = new Owner($db);
 
$data = json_decode(file_get_contents("php://input"));
 
$owner->id = $data->id;
 
$owner->fname = $data->fname;
$owner->lname = $data->lname;
$owner->street1 = $data->street1;
$owner->street2 = $data->street2;
$owner->city = $data->city;
$owner->state = $data->state;
$owner->zip = $data->zip;
$owner->policy = $data->policy;
$owner->expiration = $data->expiration;

 
if($owner->update()){
 
    http_response_code(200);
 
    echo json_encode(array("message" => "Owner was updated."));
}
 
else{
 
    http_response_code(503);
 
    echo json_encode(array("message" => "Unable to update owner."));
}
?>