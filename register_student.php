<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Register</title>

    <!-- Custom styles for this template -->
    <link href="css/auth.css" rel="stylesheet"/>
</head>

<body>
<main>
    <nav class="navbar" id="navbar-id">
        <div>
          <h1 class="mathbubbles"><span id="mathbubbles-1">ma</span><span id="mathbubbles-2">th</span>
            <span id="mathbubbles-3">bu</span><span id="mathbubbles-4">bb</span>
            <span id="mathbubbles-5">le</span><span style="color: rgb(138, 43, 226);">s</span></h1>
          <div class="menu-icon" onclick="openMenu(this)">
            <div class="bar1"></div>
            <div class="bar2"></div>
            <div class="bar3"></div>
          </div>
        </div>
        <!-- <ul class="nav-ul" id="nav-ul-id">
            <li class="nav-content"><a href="./sign_up.html">Sign Up</a></li>
        </ul> -->
    </nav>
    <div class="box">
        <h2>Register</h2>
        <form action="./includes/sign_in_inc.php" method="post">
            <div class="inputBox">
                <label for="pupil_name">Pupil Name:</label>
                <input type="text" name="pupil_name" id="pupil_name" placeholder="Jane Doe" required/>
            </div>

            <div class="button-align">
                <button type="submit" name="submit" style="float: right; background-color: rgb(23, 169, 99)">Register</button>
                <a class="button" href="" style="float: right;">Cancel</a>  
            </div>
        </form>
    </div>
</main>
<footer>
</footer>
<!-- <script src=./js/data.js></script> -->
</body>

</html>