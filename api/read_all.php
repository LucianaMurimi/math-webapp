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

    $items = new Registration($db);
    $items->db_table = isset($_GET['db_table']) ? $_GET['db_table'] : die();

    $studentArr = $items->dashboardTable();
    // $itemCount = $stmt->rowCount();
    $itemCount = sizeof($studentArr);

    // echo json_encode($itemCount);

    if($itemCount > 0){
        // $studentArr = array();
        // $studentArr["body"] = array();
        // $studentArr["itemCount"] = $itemCount;

        // while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        //     extract($row);
        //     $e = array(
        //         "id" => $id,
        //         "student_name" => $student_name,
        //     );

        //     array_push($studentArr["body"], $e);
        // }
        echo json_encode($studentArr);
    }

    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>