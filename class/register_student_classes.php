<?php
session_start();

class RegisterStudent extends Database{
    private $table_name;
    private $student_table_name;
    private $pupil_name;

    protected function registerStudent($pupil_name){
        $this->table_name = str_replace("@gmail.com", "", $_SESSION["email"]);
        
        $sqlQuery = 'INSERT INTO '. $this->table_name .' SET student_name = :pupil_name';
        
        $stmt = $this->getConnection()->prepare($sqlQuery);

        // bind data
        $stmt->bindParam(":pupil_name", $pupil_name);

        if(!$stmt->execute()){
            $stmt = null;
            header("location: ../register_student.php?error=stmtfailed");
            exit();
        }
        $stmt = null;

        $sqlQuery = 'SELECT MAX(id) FROM '. $this->table_name;
        $stmt = $this->getConnection()->prepare($sqlQuery);
        
        if(!$stmt->execute()){
            $stmt = null;
            header("location: ../register_student.php?error=stmtfailed");
        }

        $stmtResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $last_id = $stmtResult[0]["MAX(id)"];
        $this->student_table_name = $this->table_name . "_" . $last_id;

        $this->createStudentTable();
    }

    protected function createStudentTable(){
        $sqlQuery = 'CREATE TABLE '. $this->student_table_name .' (
            id INT AUTO_INCREMENT,
            time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            level_1 INT(6) DEFAULT 0,
            level_2 INT(6) DEFAULT 0,
            PRIMARY KEY (id)
        )';

        $stmt = $this->conn->prepare($sqlQuery);

        if(!$stmt->execute()){
            $stmt = null;
            header("location: ../register_student.php?error=failedtocreatetable");
            exit();
        }

        $stmt = null;
    }

}
?>