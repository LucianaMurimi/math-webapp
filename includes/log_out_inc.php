<?php
    session_start();
    session_unset();    //unset the different session variables
    session_destroy();

    //redirect to the index page
    header("location: ../index.html");
?>