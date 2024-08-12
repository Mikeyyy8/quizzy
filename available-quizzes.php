<?php

// Database connection
require_once "db.php";

// Start the session
session_start();

if($_SESSION["role"] == "admin"){
  header("location: index.php");
}

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
  <link rel="shortcut icon" href="./image/book.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body id="availableqz">
  <?php
  include_once "sidebar.php";
  ?>
  <div class="dashboard">

  <?php if (isset($_SESSION['username'])): ?>
          <p class="message">Hi, <?php echo $_SESSION['username']; ?></p>
          <p class="message welcome">Take a quiz</p>
  <?php else: ?>
      <a href="login.php">Login</a> | <a href="registration.php">Register</a>
  <?php endif; ?>

    <div class="your-progress">
      <div class="container">
      </div>
    </div>
    <div class="available-quizzes">
      <div class="create-quiz-link">
        <?php if ($_SESSION['role'] == 'admin'): ?>
            <a href="make-quiz.php" onclick="">Create Quiz</a><br>
        <?php endif; ?>
      </div>
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
</body>
</html>