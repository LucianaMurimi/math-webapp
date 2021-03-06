<?php
// Database Manipulation
class SignUp extends Database {
    private $email;
    // SET user
    protected function setUser($email, $name, $role, $passwd){
        // $stmt = $this->getConnection()->prepare(
        //     'INSERT INTO users (email, name, role, passwd) VALUES (?, ?, ?, ?);'
        // );

        // $hashedPasswd = password_hash($passwd, PASSWORD_DEFAULT);

        // // if stmt fails
        // if(!$stmt->execute(array($email, $name, $role, $hashedPasswd))){
        //     $stmt = null;
        //     header("location: ../sign_in.php?error=stmtfailed");
        //     exit();
        // }

        $sqlQuery = "INSERT INTO users SET email = :email, name = :name, role = :role, password = :passwd";
        
        $stmt = $this->conn->prepare($sqlQuery);

        $hashedPasswd = password_hash($passwd, PASSWORD_DEFAULT);
        // bind data
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":role", $role);
        $stmt->bindParam(":passwd", $hashedPasswd);

        if(!$stmt->execute()){
            $stmt = null;
            header("location: ../sign_up.php?error=stmtfailed");
            exit();
        }

        $stmt = null;
        $this->email = str_replace("@gmail.com", "", $email);
        $this->createStudentsTable();
    }

    protected function createStudentsTable(){
        $sqlQuery = 'CREATE TABLE '. $this->email .' (
            id INT AUTO_INCREMENT,
            student_name VARCHAR(32) NOT NULL,
            PRIMARY KEY (id)
        )';

        $stmt = $this->conn->prepare($sqlQuery);

        if(!$stmt->execute()){
            $stmt = null;
            header("location: ../sign_up.php?error=failedtocreatetable".$this->email);
            exit();
        }

        $stmt = null;
    }

    // protected function registerStudent($studentName){

    // }

    // protected function studentScores(){

    // }

    // check if user already exists
    protected function checkUser($email){
        $stmt = $this->getConnection()->prepare(
            'SELECT * FROM users WHERE email = ?;'
        );
        $stmt->bindParam(1, $email);
        // if stmt fails
        if(!$stmt->execute()){
            $stmt = null;
            header("location: ../sign_up.php?error=stmtfailed");
            exit();
        }

        $resultCheck;
        if($stmt->rowCount() > 0){
            $resultCheck = false;
        } else {
            $resultCheck = true;
        }
        $stmt = null;

        return $resultCheck;
    }


}