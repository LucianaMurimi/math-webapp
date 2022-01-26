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

    $item->email = $data->email;
    $item->name = $data->name;
    $item->teacher_or_guardian = $data->teacher_or_guardian;
    $item->code = $data->code;

    
    if($item->createRegistration()){
        echo 'Registration record created successfully.';
    } else{
        echo 'Registration record could not be created.';
    }
?>
