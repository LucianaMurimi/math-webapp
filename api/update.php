<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../config/database.php';
    include_once '../class/registration.php';
    
    $database = new Database();
    $db = $database->getConnection();
    
    $item = new Registration($db);
    
    $data = json_decode(file_get_contents("php://input"));
    
    $item->serial_number = $data->serial_number;
    
    // registration values
    $item->email = $data->email;
    $item->name = $data->name;
    $item->teacher_or_guardian = $data->teacher_or_guardian;
    $item->code = $data->code;
    
    if($item->updateRegistration()){
        echo json_encode("Registration record updated.");
    } else{
        echo json_encode($item->serial_number);
        echo json_encode("Registration record could not be updated");
    }
?>