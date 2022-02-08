<?php
    class Registration{

        // Connection
        private $conn;

        // Table
        // private $db_table = "registration";
        public $db_table;
        public $id;
        public $temp_db_table;

        // Columns
        public $serial_number;
        public $email;
        public $name;
        public $teacher_or_guardian;
        public $code;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getRegistrations(){
            $sqlQuery = "SELECT serial_number, email, name, teacher_or_guardian, code FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
        //=========================================================
        //READ ALL Student Records
        public function getStudents(){
            $sqlQuery = "SELECT id, student_name FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
        //=========================================================



        // CREATE
        public function createRegistration(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        email = :email, 
                        name = :name, 
                        teacher_or_guardian = :teacher_or_guardian, 
                        code = :code";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->teacher_or_guardian=htmlspecialchars(strip_tags($this->teacher_or_guardian));
            $this->code=htmlspecialchars(strip_tags($this->code));
        
            // bind data
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":teacher_or_guardian", $this->teacher_or_guardian);
            $stmt->bindParam(":code", $this->code);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // READ single
        public function getSingleRegistration(){
            $sqlQuery = "SELECT serial_number, email, name, teacher_or_guardian, code
                      FROM ". $this->db_table ." WHERE serial_number = ?";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->serial_number);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->serial_number = $dataRow['serial_number'];
            $this->email = $dataRow['email'];
            $this->name = $dataRow['name'];
            $this->teacher_or_guardian = $dataRow['teacher_or_guardian'];
            $this->code = $dataRow['code'];
        } 

        //=========================================================
        //READ SINGLE Student Record
        // READ single
        public function getSingleStudentScores(){
            $sqlQuery = "SELECT id, time, level_1, level_2 FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
        //=========================================================
        // RETURN SUM OF COLUMN
        // public function getLevelOneSum(){
        //     $sqlQuery = "SELECT SUM(level_1) FROM " . $this->db_table . "";
        //     $stmt = $this->conn->prepare($sqlQuery);
        //     $stmt->execute();
        //     return $stmt;
        // }

        public function getLevelOneSum($table_name){
            $this->temp_db_table = $table_name;
            $sqlQuery = "SELECT SUM(level_1) FROM " . $this->temp_db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        public function getLevelTwoSum($table_name){
            $this->temp_db_table = $table_name;
            $sqlQuery = "SELECT SUM(level_2) FROM " . $this->temp_db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
        //=========================================================

        public function dashboardTable(){
            $studentArr = array();
            $studentArr["body"] = array();
            // $studentArr["itemCount"] = $itemCount;

            $sqlQuery = "SELECT id, student_name FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            
            // while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)){
            //     extract($row);
            //     // echo json_encode($row);
                
            //     $table_name = $this->db_table . "_" . $id;

            //     $stmt2 = $this->getLevelOneSum($table_name);
            //     $stmt2Res = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            //     $levelOneSum = $stmt2Res[0]["SUM(level_1)"];

            //     $sumRes = $this->getLevelTwoSum($table_name);
            //     $levelTwoSum = $sumRes[0]["SUM(level_2)"];

            //     $e = array(
            //         "id" => $id,
            //         "student_name" => $student_name,
            //         "level_one" => $levelOneSum,
            //         "level_two" => $levelTwoSum,
            //     );
    
            //     array_push($studentArr["body"], $e);
            // }

            foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
                // echo json_encode($row);

                $table_name = $this->db_table . "_" . $row["id"];

                $stmt2 = $this->getLevelOneSum($table_name);
                $stmt2Res = $stmt2->fetch(PDO::FETCH_ASSOC);
                $levelOneSum = $stmt2Res["SUM(level_1)"];

                $stmt3 = $this->getLevelTwoSum($table_name);
                $stmt3Res = $stmt3->fetch(PDO::FETCH_ASSOC);
                $levelTwoSum = $stmt3Res["SUM(level_2)"];

                $e = array(
                        "id" => $row["id"],
                        "student_name" => $row["student_name"],
                        "level_one" => $levelOneSum,
                        "level_two" => $levelTwoSum,
                        "total_score" => $levelOneSum + $levelTwoSum,
                    );
        
                array_push($studentArr["body"], $e);

            }

            return $studentArr;
        }

        // UPDATE
        // UPDATE
        public function updateRegistration(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        email = :email,
                        name = :name, 
                        teacher_or_guardian = :teacher_or_guardian, 
                        code = :code
                    WHERE 
                        serial_number = :serial_number";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->teacher_or_guardian=htmlspecialchars(strip_tags($this->teacher_or_guardian));
            $this->code=htmlspecialchars(strip_tags($this->code));
            $this->serial_number=htmlspecialchars(strip_tags($this->serial_number));
        
            // bind data
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":teacher_or_guardian", $this->teacher_or_guardian);
            $stmt->bindParam(":code", $this->code);
            $stmt->bindParam(":serial_number", $this->serial_number);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteRegistration(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE serial_number = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->serial_number));
        
            $stmt->bindParam(1, $this->serial_number);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }

        //=========================================================
        //DELETE SINGLE Student Record
        function deleteStudent(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                $this->db_table = $this->db_table . "_" . $this->id;
                $sqlQuery = "DROP TABLE " . $this->db_table;
                $stmt = $this->conn->prepare($sqlQuery);
                if($stmt->execute()){
                    return true;
                }
                return false;
            }
            return false;
        }
        
        //=========================================================

    }
?>