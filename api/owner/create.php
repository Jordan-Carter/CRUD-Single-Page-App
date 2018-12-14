<?php
include_once 'C:\xampp\htdocs\api\config\database.php';
include_once 'C:\xampp\htdocs\api\objects\owners.php';
 
$database = new Database();
$db = $database->getConnection();
 
$owner = new Owner($db);
 
$data = json_decode(file_get_contents("php://input"));
 
if(
    !is_null($data->fname) &&
    !is_null($data->lname) &&
    !is_null($data->street1) &&
    !is_null($data->street2) &&
    !is_null($data->city) &&
    !is_null($data->state) &&
    !is_null($data->zip) &&
    !is_null($data->expiration) &&
    !is_null($data->policy)
){
 
    $owner->fname = $data->fname;
    $owner->lname = $data->lname;
    $owner->street1 = $data->street1;
    $owner->street2 = $data->street2;
    $owner->city = $data->city;
    $owner->state = $data->state;
    $owner->zip = $data->zip;
    $owner->policy = $data->policy;
    $owner->expiration = $data->expiration;

    if($owner->create()){
 
        http_response_code(201);
 
        echo json_encode(array("message" => "Owner was created."));
    }
 
    else{
 
        http_response_code(503);
 
        echo json_encode(array("message" => "Unable to create owner."));
    }
}
 
else{
 
    http_response_code(400);
 
    echo json_encode(array("message" => "Unable to create owner. Data is incomplete."));
}
?>