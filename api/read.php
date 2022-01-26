<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../config/database.php';
    include_once '../class/registration.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new Registration($db);

    $stmt = $items->getRegistrations();
    $itemCount = $stmt->rowCount();


    echo json_encode($itemCount);

    if($itemCount > 0){
        
        $registrationArr = array();
        $registrationArr["body"] = array();
        $registrationArr["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "serial_number" => $serial_number,
                "email" => $email,
                "name" => $name,
                "teacher_or_guardian" => $teacher_or_guardian,
                "code" => $code,
            );

            array_push($registrationArr["body"], $e);
        }
        echo json_encode($registrationArr);
    }

    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>