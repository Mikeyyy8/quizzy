<?php
session_start();

require_once "db.php";
$course = isset($_GET['course']) ? $connect->real_escape_string($_GET['course']) : '';

// var_dump($course);
// exit;

$sql = "SELECT *, DATE(date) as date FROM grade ORDER BY score DESC";

if($course){
  $sql .= " WHERE quiz_id='$course'";
}
$grades = mysqli_query($connect, $sql);

$count = 1;

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
  <script src="script.js"></script> 
</head>

<body id="leaderboard">
<?php
  include_once "sidebar.php";
?>
<div class="container">
  <div class="header">
    <div class="go-home">
      <a href="index.php">Go home</a>
    </div>
  
    <div class="rank">
      <p>leaderboard</p>
    </div>
  
    <div class="sort">
      <p>Filter-by:</p>
      <select name="filter" id="filter">
        <option value="None">None</option>
        <!-- Content will be added here dynamically -->
      </select>
    </div>
  </div>
  <div class="leaderboard-container">
    <table class="table">
      <tr class="bg-dark text-white">
        <th scope="col">id</th>
        <th scope="col">Course</th>
        <th scope="col">Username</th>
        <th scope="col">Score</th>
        <th scope="col">Date</th>
        <th scope="col">Rank</th>
      </tr>
      <tr>
        <?php
        while($grade = mysqli_fetch_assoc($grades)){
        ?>
        <td> <?php echo $count++; ?></td>
        <td> <?php echo $grade["quiz_id"]; ?></td>
        <td> <?php echo $grade["username"]; ?></td>
        <td> <?php echo $grade["score"]; ?> </td>
        <td> <?php echo $grade["date"]; ?></td>
      </tr>
      <?php
        }
      ?>
    </table>
  </div>
</div>
</body>
</html>


