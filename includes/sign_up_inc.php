<?php

if(isset($_POST['submit'])){
    // 1. grab data
    $email = $_POST["email"];
    $name = $_POST["name"];
    $role = $_POST["role"];
    $passwd = $_POST["passwd"];
    $confirmPasswd = $_POST["confirmPasswd"];
    
    // 2. instantiate SignUpContr class
    include "../config/database.php";
    include "../class/sign_up_classes.php";
    include "../class/sign_up_contr_classes.php";

    $signup = new SignUpContr($email, $name, $role, $passwd, $confirmPasswd);

    // 3. running error handlers and user sign up
    $signup->signUpUser();

    // 4. back to sign_up.php
    header("location: ../sign_in.php?error=none");
}