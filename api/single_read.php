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

    $item->serial_number = isset($_GET['serial_number']) ? $_GET['serial_number'] : die();
  
    $item->getSingleRegistration();

    if($item->name != null){
        // create array
        $emp_arr = array(
            "serial_number" => $item->serial_number,
            "email" => $item->email,
            "name" => $item->name,
            "teacher_or_guardian" => $item->teacher_or_guardian,
            "code" => $item->code,
        );
      
        http_response_code(200);
        echo json_encode($emp_arr);
    }
      
    else{
        http_response_code(404);
        echo json_encode("Registration record not found.");
    }
?>