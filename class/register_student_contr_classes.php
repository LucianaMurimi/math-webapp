<?php
 class RegisterStudentContr extends RegisterStudent{
    private $pupil_name;

    // constructor
    public function __construct($pupil_name) {
        $this->pupil_name = $pupil_name;
    }

    // if no errors exist; sign up user
    public function registerPupil(){
        if($this->emptyInput() == false){
            header("location: ../register_student.php?error=emptyinput");
            exit();
        }
        
        $this->registerStudent($this->pupil_name);
    }    

    // check for empties
    private function emptyInput(){
        // return True -> everything was filled correctly
        // return False -> missing

        $result;
        if(empty($this->pupil_name)){
            $result = false;
        } else {
            $result = true;
        }

        return $result;
    } 
 }
?>