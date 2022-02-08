<?php
    session_start();
    session_unset();    //unset the different session variables
    session_destroy();
    setcookie("email", time() - 3600);

    //redirect to the index page
    header("location: ../index.html");
?>