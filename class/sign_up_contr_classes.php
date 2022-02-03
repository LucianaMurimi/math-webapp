<?php

class SignUpContr extends SignUp{
    private $email;
    private $name;
    private $role;
    private $passwd;
    private $confirmPasswd;

    // constructor
    public function __construct($email, $name, $role, $passwd, $confirmPasswd) {
        $this->email = $email;
        $this->name = $name;
        $this->role = $role;
        $this->passwd = $passwd;
        $this->confirmPasswd = $confirmPasswd;
    }

    // if no errors exist; sign up user
    public function signUpUser(){
        if($this->emptyInput() == false){
            header("location: ../sign_in.php?error=emptyinput");
            exit();
        }
        if($this->invalidEmail() == false){
            header("location: ../sign_in.php?error=invalidemail");
            exit();
        }
        if($this->passwdMatch() == false){
            header("location: ../sign_in.php?error=passwd");
            exit();
        }
        if($this->emailExist() == false){
            header("location: ../sign_in.php?error=email");
            exit();
        }

        $this->setUser($this->email, $this->name, $this->role, $this->passwd);
    }

    // check for empties
    private function emptyInput(){
        // return True -> everything was filled correctly
        // return False -> missing

        $result;
        if(empty($this->email) || empty($this->name) || empty($this->role) || empty($this->passwd)
        || empty($this->confirmPasswd)){
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    }

    // check if email is valid
    private function invalidEmail(){
        $result;
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            $result = false;
        }else{
            $result = true;
        }

        return $result;
    }

    // check if password match
    private function passwdMatch(){
        $result;
        if($this->passwd !== $this->confirmPasswd){
            $result = false;
        }else{
            $result = true;
        }

        return $result;
    }

    // check if user already exists
    private function emailExist(){
        $result;
        if(!$this->checkUser($this->email)){
            $result = false;
        }else{
            $result = true;
        }

        return $result;
    }

}