<?php
include_once 'C:\xampp\htdocs\api\config\database.php';
include_once 'C:\xampp\htdocs\api\objects\owners.php';
 
$database = new Database();
$db = $database->getConnection();
 
$owner = new Owner($db);
 
$owner->id = isset($_GET['id']) ? $_GET['id'] : die();
 
$owner->readOne();
 
if($owner->id!=null){
    $owner_arr = array(
        "id" =>  $owner->id,
        "fname" => $owner->fname,
        "lname" => $owner->lname,
        "street1" => $owner->street1,
        "street2" => $owner->street2,
        "city" => $owner->city,
        "state" => $owner->state,
        "zip" => $owner->zip,
        "expiration" => $owner->expiration,
        "policy" => $owner->policy
    );
 
    http_response_code(200);
 
    echo json_encode($owner_arr);
}
 
else{

    http_response_code(404);
 
    echo json_encode(array("message" => "Owner does not exist."));
}
?>