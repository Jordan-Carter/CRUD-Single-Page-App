<?php
include_once 'C:\xampp\htdocs\api\config\database.php';
include_once 'C:\xampp\htdocs\api\objects\owners.php';
 
$database = new Database();
$db = $database->getConnection();
 
$owner = new Owner($db);

//$keywords = isset($_GET["filter"]) ? $_GET["filter"] : "";
$pagenum = isset($_GET['pagenum']) ? $_GET['pagenum'] : die();

$stmt = $owner->read($pagenum, 10);
$num = $stmt->rowCount();
 
if($num>0){

    $owners_arr["owners"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
 
        $owner_item=array(
            "id" => $id,
            "fname" => $fname,
            "lname" => $lname,
            "street1" => $street1,
            "street2" => $street2,
            "city" => $city,
            "state" => $state,
            "zip" => $zip,
            "policy" => $policy,
            "expiration" => $expiration
        );
 
        array_push($owners_arr["owners"], $owner_item);
    }
 
    http_response_code(200);

    echo json_encode($owners_arr);
}
 
else{
 
    http_response_code(404);
 
    echo json_encode(
        array("message" => "Not found")
    );

}
?>