<?php

class SignInContr extends SignIn{
    private $email;
    private $name;

    // constructor
    public function __construct($email, $passwd) {
        $this->email = $email;
        $this->passwd = $passwd;
    }

    // if no errors exist; sign up user
    public function signInUser(){
        if($this->emptyInput() == false){
            header("location: ../sign_up.php?error=emptyinput");
            exit();
        }
        
        $this->signUserIn($this->email, $this->passwd);
    }

    // check for empties
    private function emptyInput(){
        // return True -> everything was filled correctly
        // return False -> missing

        $result;
        if(empty($this->email) || empty($this->passwd)){
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    } 

}