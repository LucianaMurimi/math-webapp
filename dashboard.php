<?php
    session_start();
    setcookie("email", $_SESSION["email"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- displays site properly based on user's device -->

  <link rel="icon" type="image/png" sizes="32x32" href="./images/bubble_32px.png">
  <link rel="stylesheet" type="text/css" href="css/styles.css">
  <link rel="stylesheet" type="text/css" href="https://unpkg.com/ionicons@4.4.6/dist/css/ionicons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
  <title>math bubbles</title>
</head>
<body>
  <div class="page-wrapper">
    <main class="dashboard">
      <div>
        <nav class="navbar" id="navbar-id">
          <div>
            <h1 class="mathbubbles"><span id="mathbubbles-1">ma</span><span id="mathbubbles-2">th</span>
              <span id="mathbubbles-3">bu</span><span id="mathbubbles-4">bb</span>
              <span id="mathbubbles-5">le</span><span style="color: rgb(138, 43, 226);">s</span></h1>
          </div>
          <div class="dashboard-signout"><a href="./includes/log_out_inc.php"><i class="fa fa-sign-out" style="color:#000;"></i> Log Out</a></div>
        </nav>
      </div>
      <!-- ----------------------------------------------------------- -->
      <div class="split">
			  <div class="left">
			    <div class = "summary">
                    <p></strong><?php echo($_SESSION["name"]);?></p>
                    <p></strong><?php echo($_SESSION["email"]);?></p>
                    <p></strong><?php echo($_SESSION["role"]);?></p>
                </div>

                <div class = "actions">
                   <form action="" method="post">
                    <p><button name="students" value=""><strong style="color: #000;"><i class="fa fa-users" style="color:#353839;"></i>&nbsp; Students</strong></button></p>
                    <p><button name="scoreboard" value=""><strong style="color: #000;"><i class="fa fa-table" style="color:#353839;"></i>&nbsp; ScoreBoard</strong></button></p>

                    <!-- <p><a><strong style="color: #000;"><i class="fa fa-table" style="color:#353839"></i>&nbsp; ScoreBoard</strong></a></p> -->
                    <p><a href="./register_student.php"><strong style="color: #000;"><i class="fa fa-edit" style="color:#353839"></i>&nbsp; Register</strong></a></p>
                   </form>
                </div>
        </div>
      <!-- ----------------------------------------------------------- -->
        <div class = "right">
            <!-- <div class = "right-nav">
                <div>
                <button>ScoreBoard</button>
                <button>Register</button>
                <button>Student</button>
                </div>
                <div class="dashboard-signout"><i class="fa fa-sign-out" style="color:#000;"></i> Log Out</div>
            </div> -->
            <div class = "visuals">
                <?php
                  if(isset($_POST['students'])){ ?>
                    <div>
                      <h1 class="dashboard-h1">Students</h1>
                      <table>
                        <tbody id="students">
                        <tr id="theader">
                          <th>ID</th>
                          <th>PUPIL NAME</th>
                          <th style="float: right; padding-right: 16px;">REMOVE PUPIL RECORD</th>
                        </tr>

                        </tbody>
                      </table>
                    </div>
                  <?php }elseif (isset($_POST['scoreboard'])){ ?>
                    <div>
                      <h1 class="dashboard-h1">Performance Chart</h1>
                      <canvas id="myChart"  style="max-width:60vw;max-height:40vh"></canvas>
                    </div>
    
                    <div>
                        <h1 class="dashboard-h1">Score Board</h1>
                        <table id="scoreboard">
                            <tbody>
                            <tr>
                                <td><strong>S/N</strong></td>
                                <td><strong>Name</strong></td>
                                <td><strong>Total Score</strong></td>
                            </tr>
                            <tr>
                                <td>01</td>
                                <td>Jane Doe</td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>02</td>
                                <td>John Doe</td>
                                <td>2</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                  <?php } else { ?>
                    <div>
                      <h1 class="dashboard-h1">Performance Chart</h1>
                      <canvas id="myChart"  style="max-width:60vw;max-height:40vh"></canvas>
                    </div>
    
                    <div>
                        <h1 class="dashboard-h1">Score Board</h1>
                        <table id="scoreboard">
                            <tbody>
                            <tr>
                                <td><strong>S/N</strong></td>
                                <td><strong>Name</strong></td>
                                <td><strong>Total Score</strong></td>
                            </tr>
                            <tr>
                                <td>01</td>
                                <td>Jane Doe</td>
                                <td>3</td>
                            </tr>
                            <tr>
                                <td>02</td>
                                <td>John Doe</td>
                                <td>2</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                  <?php } ?>
                
            </div>
        </div>
			  
    </main>
  </div>
<script src=./js/dashboard.js></script>
</body>
</html>