<?php
    class Registration{

        // Connection
        private $conn;

        // Table
        private $db_table = "registration";

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

    }
?>