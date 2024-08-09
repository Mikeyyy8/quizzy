<?php

// Database conection 
require_once "db.php";

session_start();

$username = $_SESSION["username"];
$quiz_id = $_SESSION["quiz_id"];
$score = $_SESSION["score"];
$total_questions = $_SESSION["total_questions"];
$percentage = ($score / $total_questions) * 100;


// Save user answer to the database
$sql = "INSERT INTO grade (quiz_id, username, score, total_questions) VALUES ('$quiz_id', '$username', '$score', '$total_questions')";
mysqli_query($connect, $sql);
mysqli_close($connect);

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

<body id="grade">
    <div class="grade_container">        
        <h1>Quiz Results</h1>
        <p>Your Score: <?php echo $_SESSION["score"] . "/" . $total_questions; ?></p>
        <p>Percentage: <?php echo round($percentage, 2) . "%"; ?></p>
        <?php unset($_SESSION['current_question'], $_SESSION["score"], $_SESSION["quiz_id"], $_SESSION["total_questions"], $_SESSION["ongoing"]); ?>

        <div class="navigation-links">
          <a href="index.php">Back to Home</a>
          <a href="leaderboard.php">View Leaderboard</a>
        </div>
    </div>
</body>
</html>
