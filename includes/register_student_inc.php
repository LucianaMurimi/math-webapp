<?php
if(isset($_POST['submit'])) {
    // 1. grab data
    $pupil_name = $_POST["pupil_name"];

    // 2. instantiate SignUpContr class
    include "../config/database.php";
    include "../class/register_student_classes.php";
    include "../class/register_student_contr_classes.php";

    $register = new RegisterStudentContr($pupil_name);

    // 3. running error handlers and user sign up
    $register->registerPupil();

    // 4. back to sign_up.php
    header("location: ../dashboard.php?error=none");
}
?>