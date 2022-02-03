<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Sign Up</title>

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
        <h2>Sign Up</h2>
        <form action="./includes/sign_up_inc.php" method="post">
            <div class="inputBox">
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" placeholder="example@gmail.com" required/>
            </div>
            <div class="inputBox">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" placeholder="Jane Doe" required/>
            </div>

            <label for="teacher_or_guardian">Select role:</label><br>
            <fieldset>
                <div class="radio-class">
                    <input type="radio" class="radio" name="role" value="Teacher" id="role" />
                    <label for="Teacher">Teacher</label>
                    <input type="radio" class="radio" name="role" value="Parent | Guardian" id="role" />
                    <label for="Parent | Guardian">Parent | Guardian</label><br>
                </div>
            </fieldset>

            <div class="inputBox">
                <label for="passwd">Password: </label>
                <input type="" name="passwd" id="passwd" placeholder="password" required/>
            </div>
            <div class="inputBox">
                <label for="confirmPasswd">Confirm Password: </label>
                <input type="" name="confirmPasswd" id="confirmPasswd" placeholder="password" required/>
            </div>

            <div class="buttons-align">
                <a class="button" href="./sign_in.php" style="float: right;">Sign In</a>
                <button type="submit" name="submit" style="float: right; background-color: rgb(23, 169, 99)">Sign Up</button>
            </div>
        </form>
    </div>
</main>
<footer>
</footer>
</body>

</html>