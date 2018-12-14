<?php
include_once 'C:\xampp\htdocs\api\config\database.php';
include_once 'C:\xampp\htdocs\api\objects\items.php';
 
$database = new Database();
$db = $database->getConnection();
 
$item = new Item($db);

$key = isset($_GET['ownerkey']) ? $_GET['ownerkey'] : die();

$stmt = $item->read_items($key);
$num = $stmt->rowCount();
 
if($num>0){

    $item_arr["items"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
 
        $item=array(
            "id" => $id,
            "name" => $name,
            "photo" => $photo,
            "description" => $description,
            "valuation" => $valuation,
            "method" => $method,
            "verified" => $verified,
            "creationDate" => $creationDate
        );
 
        array_push($item_arr["items"], $item);
    }
 
    http_response_code(200);

    echo json_encode($item_arr);
}
 
else{
 
    http_response_code(404);
 
    echo json_encode(
        array("message" => "Not found")
    );

}
?>