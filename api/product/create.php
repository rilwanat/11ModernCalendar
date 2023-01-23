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

//$m_id = $_GET["m_id"];
$m_date = date('Y-m-d H:i:s');//$_GET["m_dat"];
$m_edited = date('Y-m-d H:i:s');//$_GET["m_edi"];
$m_username = $_GET["m_use"];
$m_password = $_GET["m_pas"];
$m_firstname = $_GET["m_fir"];
$m_lastname = $_GET["m_las"];
$m_department = $_GET["m_dep"];
$m_birthday = $_GET["m_bir"];
$m_phone = $_GET["m_pho"];
$m_email = $_GET["m_ema"];


//$product->reg_id  = $m_id;
$product->reg_date  = $m_date;
$product->reg_edited  = $m_edited;
$product->reg_username  = $m_username;
$product->reg_password  = $m_password;
$product->reg_firstname  = $m_firstname;
$product->reg_lastname  = $m_lastname;
$product->reg_department  = $m_department;
$product->reg_birthday  = $m_birthday;
$product->reg_phone  = $m_phone;
$product->reg_email  = $m_email;

    // set product property values
    //$product->name = $data->name;
    //$product->price = $data->price;
    //$product->description = $data->description;
    //$product->category_id = $data->category_id;
    //$product->created = date('Y-m-d H:i:s');
    
    // create the product
    if($product->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "Good Job. Registered succesfully."));
    }else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to register."));
    }


?>