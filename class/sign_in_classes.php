<?php
// Database Manipulation
class SignIn extends Database {
    // SET user
    protected function signUserIn($email, $passwd){
        $stmt = $this->getConnection()->prepare(
            'SELECT * FROM users WHERE email = ?;'
        );
        $stmt->bindParam(1, $email);

        if(!$stmt->execute()){
            $stmt = null;
            header("location: ../sign_in.php?error=stmtfailed");
            exit();
        }

        if($stmt->rowCount() == 0){
            $stmt = null;
            header("location: ../sign_in.php?error=usernotfound");
            exit();
        }

        $stmtResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPasswd = password_verify($passwd, $stmtResult[0]["password"]);

        if($checkPasswd == false){
            $stmt = null;
            header("location: ../sign_in.php?error=wrongpassword");
            exit();
        }
        elseif($checkPasswd == true){
            //start a session and assign session variables
            session_start();
            $_SESSION["email"] = $stmtResult[0]["email"];
            $_SESSION["name"] = $stmtResult[0]["name"];
            $_SESSION["role"] = $stmtResult[0]["role"];
            
        }

        $stmt = null;

    }


} 