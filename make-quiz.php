<?php

require_once "db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quiz_id = trim($_POST["quiz_id"]);
    $title = $_POST['title'];
    $creator = $_POST['creator'];
    $description = $_POST['description'];
    $_SESSION["quiz_id"] = $quiz_id;

    // Insert quiz into the database
    $sql = "INSERT INTO quiz_new (quiz_id, title, creator, description) VALUES ('$quiz_id', '$title', '$creator', '$description')";
    mysqli_query($connect, $sql);

    header('location: fill_information.php');
}

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

<body id="make-quiz">
    <div class="home">
        <a href="index.php" class="back">Go home</a>
    </div>
    <div class="create-quiz">
        <div class="container">
            <form method="POST" id="quiz_information_form">
                <div class="quiz-information">
                    <div class="quiz_id">
                        Quiz ID:<input type="text" name="quiz_id" required class="information" placeholder="E.g: CPE504">
                    </div>
                    <div class="title">
                        Title:<input type="text" name="title" required class="information">
                    </div>
                    <div class="creator">
                        Lecturer:<input type="text" name="creator" required class="information" value="<?php echo $_SESSION['username']; ?>">
                    </div>
                    <div class="description">
                        Description:<textarea name="description" required></textarea>
                    </div>
                </div>
                <div class="submit">
                    <button type="submit" name="quiz_info">Create Quiz</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>