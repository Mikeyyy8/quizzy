<?php

require_once "db.php";

$sql = "SELECT * FROM grade";
$grades = mysqli_query($connect, $sql);

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

<body id="leaderboard">
  <div class="header">
    <div class="home">
    </div>

    <div class="rank">
      <p>RANK</p>
    </div>

    <div class="sort">
      
    </div>
  </div>
  <div class="leaderboard-container">
    <table class="table">
      <tr class="bg-dark text-white">
        <th scope="col">id</th>
        <th scope="col">quiz_id</th>
        <th scope="col">Username</th>
        <th scope="col">Score</th>
        <th scope="col">Time</th>
        <th scope="col">Date_Taken</th>
      </tr>
      <tr>
        <?php
        while($grade = mysqli_fetch_assoc($grades)){ 
        ?>
        <td> <?php echo $grade["id"]; ?></td>
        <td> <?php echo $grade["quiz_id"]; ?></td>
        <td> <?php echo $grade["username"]; ?></td>
        <td> <?php echo $grade["score"]; ?></td>
        <td> <?php echo $grade["date"]; ?></td>
      </tr>
      <?php
        }
      ?>
    </table>
  </div>
</body>


