<?php

// Database connection
require_once "db.php";

// Start the session
session_start();

// Quiz ongoing session for take-quiz.php page 
$_SESSION["ongoing"] = "";

$create_quiz = $no_quiz = "";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Quizzy</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>

<body>
<?php if (isset($_SESSION["loggedin"])): ?>
    <aside>
        <nav class="sidebar">
          <div class="sidebar-top-wrapper">
            <div class="sidebar-top">
              <a href="#" class="logo__wrapper">
                <img src="assets/logo.svg" alt="Logo" class="logo-small">
                <span class="hide company-name">
                  QUIZZy
                </span>
              </a>
            </div>
          </div>
      
          <div class="sidebar-links">
            <ul>
              <li>
                <a href="#dashboard" title="Dashboard" class="tooltip active">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-layout-dashboard" width="24"
                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round" aria-hidden="true">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 4h6v8h-6z" />
                    <path d="M4 16h6v4h-6z" />
                    <path d="M14 12h6v8h-6z" />
                    <path d="M14 4h6v4h-6z" />
                  </svg>
                  <span class="link hide" >Dashboard</span>
                </a>
              </li>

              <li>
                <a href="#analytics" title="Analytics" class="tooltip">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chart-pie" width="24"
                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round" aria-hidden="true">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M10 3.2a9 9 0 1 0 10.8 10.8a1 1 0 0 0 -1 -1h-6.8a2 2 0 0 1 -2 -2v-7a.9 .9 0 0 0 -1 -.8" />
                    <path d="M15 3.5a9 9 0 0 1 5.5 5.5h-4.5a1 1 0 0 1 -1 -1v-4.5" />
                  </svg>
                  <span class="link hide">Analytics</span>
                </a>
              </li>

              <li>
                <a href="#settings" title="Settings" class="tooltip">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path
                      d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z">
                    </path>
                    <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                  </svg>
                  <span class="link hide">Settings</span>
                </a>
              </li>
            </ul>
          </div>
          <div class="sidebar__profile">
            <div class="avatar__wrapper">
              <img class="avatar" src="" alt="">
              <div class="online__status"></div>
            </div>
            <div class="avatar__name hide">
              <div class="user-name"><?php echo $_SESSION['username']; ?></div>
              <div class="email" style="font-size: 8px;"><?php echo $_SESSION['email']; ?></div>
            </div>
            <a href="logout.php" class="logout hide"  onclick='return confirm("Are you sure?")'">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-logout" width="24" height="24"
                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                stroke-linejoin="round" aria-labelledby="logout-icon" role="img">
                <title id="logout-icon">log out</title>
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
                <path d="M9 12h12l-3 -3"></path>
                <path d="M18 15l3 -3"></path>
              </svg>
            </a>
          </div>
        </nav>
    </aside>
<?php endif; ?>

<div class="dashboard" id="dashboard">
  <div class="container">
    <?php if (isset($_SESSION['username'])): ?>
        <p class="message">Welcome, <?php echo $_SESSION['username']; ?></p>
    <?php else: ?>
        <a href="login.php">Login</a> | <a href="registration.php">Register</a>
    <?php endif; ?>

    <div class="available-quizzes">
      <div class="create-quiz-link">
        <?php if ($_SESSION['role'] == 'admin'): ?>
            <a href="make-quiz.php" onclick="">Create Quiz</a><br>
        <?php endif; ?>
      </div>
      
      <h1>Available Quizzes</h1>
      <?php

      // Fetch available quizzes
      $sql = "SELECT * FROM quiz_new ORDER BY id ASC";
      $quizzes_result = $connect->query($sql);
      if ($quizzes_result->num_rows > 0) {
          while ($quiz = $quizzes_result->fetch_assoc()) {
      ?>
      <div class="quiz-information">
        <div class="quiz-information-card" id="quizzies" onload="getQuizzes()">
          <div class="quiz-id">
            <h4><?php echo $quiz["id"];?> <?php echo $quiz["quiz_id"]; ?></h4>
            <h4>Title: <a href="take-quiz.php?id=<?php echo $quiz["id"]; ?>"><?php echo $quiz["title"]; ?></a></h4>
          </div>
          <div class="quiz-description">  
            <p>Description: <?php echo $quiz["description"]; ?></p>
          </div>
          <div class="quiz-creator">
            <p>Added-By: <?php echo $quiz["creator"]; ?></p>
          </div>
        </div>
        <?php
      }
      } else {
          $no_quiz = "No quizzes available!";
          echo $no_quiz;
      }
      ?>
      </div>
      <?php
      mysqli_close($connect);
      ?>
    </div>
  </div>
</div>

<script>
  function getQuizzes(str){
    if(str == ""){
      document.getElementById("quizzies").innerHTML = "No quizzes available!";
      return;
    }
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function(){
      document.getElementById("quizzies").innerHTML = this.responseText;
    }
    xhttp.open("GET", "index.php?q"=+str);
    xhttp.send();
  }
</script>
</body>
</html>
