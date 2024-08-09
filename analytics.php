<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Quizzy</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="script.js"></script>
</head>

<body id="analytics">
    <button onclick="showLeaderboard()">Show Leaderboard</button>
    <div class="board" id="leaderboard">

    </div>
    
<script>
    function showLeaderboard(){
        let xhr = new XMLHttpRequest();

        xhr.open("GET", "leaderboard.php", true);

        xhr.onload = function () {
            if(xhr.status == 200){
                document.getElementById("leaderboard").innerHTML = xhr.responseText;
            }
          }
          xhr.send();
    }
</script>
</body>
</html>