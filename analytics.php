<?php

session_start();

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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="chart.js"></script>
</head>

<body id="analytics">
<?php
  include_once "sidebar.php";
?>
<div class="container">
  <header class="searchbar">
    <button onclick="showChart()" id="leader">Show Chart</button>
    <p>Analytics</p>
    <?php if($_SESSION["role"] == "admin"): ?>
    <div class="search"></div>
    <?php endif; ?>
    <a href="leaderboard.php" class="to-leaderboard">To leaderboard </a>
  </header>
  <div class="chart" id="chart" style="display: none;">
    <label for="courseSelect">Select Course:</label>
    <select id="courseSelect">
        <!-- Options will be populated dynamically -->
    </select>
    <canvas id="scoreChart" width="400" height="200">
    </canvas>
  </div>
</div>
<script>
    function showChart(){
      let x = document.getElementById("chart");
      let y = document.getElementById("leader");
      if (x.style.display === "none") {
        x.style.display = "block";
        if (y.innerHTML === "Show Chart"){
          y.innerHTML == "Hide chart";
        }
      } else {
        x.style.display = "none";
        y.innerHTML == "Show Chart";
      }
    }
</script>

</body>
</html>