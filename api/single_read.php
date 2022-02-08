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
    // $items->id = isset($_GET['id']) ? $_GET['id'] : die();

    $stmt = $items->getSingleStudentScores();
    $itemCount = $stmt->rowCount();

    $stmt2 = $items->getLevelOneSum($items->db_table);
    $stmt2Res = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    $levelOneSum = $stmt2Res[0]["SUM(level_1)"];

    echo json_encode($itemCount);


    
    if($itemCount > 0){
        $studentArr = array();
        $studentArr["body"] = array();
        $studentArr["itemCount"] = $itemCount;
        $studentArr["levelOneSum"] = $levelOneSum;


        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "time" => $time,
                "level_1" => $level_1,
                "level_2" => $level_2,
            );

            array_push($studentArr["body"], $e);
        }
        echo json_encode($studentArr);
    }

    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>