<?php

if(isset($_POST['submit'])){
    // 1. grab data
    $email = $_POST["email"];
    $passwd = $_POST["passwd"];

    // 2. instantiate SignUpContr class
    include "../config/database.php";
    include "../class/sign_in_classes.php";
    include "../class/sign_in_contr_classes.php";

    $signin = new SignInContr($email, $passwd);

    // 3. running error handlers and user sign up
    $signin->signInUser();

    // echo($_SESSION["email"]);
    // echo($_SESSION["name"]);
    // echo($_SESSION["role"]);

    // 4. back to sign_up.php
    header("location: ../dashboard.php");
}