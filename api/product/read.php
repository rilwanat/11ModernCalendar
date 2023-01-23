<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/product.php';
 
$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

// read products will be here
// query products
$stmt = $product->read();
$num = $stmt->rowCount();

if($num>0){
 
    // products array
    $products_arr=array();
    $products_arr["#REGISTRATIONS"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $product_item=array(
            "#id" => $reg_id,
            "#reg_date" => $reg_date,
            "#reg_edited" => $reg_edited,
            "#reg_username" => $reg_username,

            "#reg_password" => $reg_password,
            "#reg_firstname" => $reg_firstname,
            "#reg_lastname" => $reg_lastname,
            "#reg_department" => $reg_department,
            "#reg_birthday" => $reg_birthday,
            "#reg_phone" => $reg_phone,
            "#reg_email" => $reg_email
        );
 
        array_push($products_arr["#REGISTRATIONS"], $product_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($products_arr);
}
 
// no products found will be here
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no products found
    echo json_encode(
        array("message" => "No registrations found.")
    );
}


?>