<?php

// Database connection 
require_once "db.php";
session_start();

// Quiz started
if (isset($_POST["start-quiz"])){
    $_SESSION["ongoing"] = true;
}

$quiz_id = $_GET['id'];  

// Fetch quiz details
$sql = "SELECT * FROM quiz_new WHERE id='$quiz_id'";
$quiz_result = mysqli_query($connect, $sql);

if ($quiz_result->num_rows == 0) {
    die("Quiz not found");
}

$quiz = $quiz_result->fetch_assoc();

// Quiz id session
$_SESSION["quiz_id"] = $quiz["quiz_id"];
$_SESSION["id"] = $quiz["id"];

// Handling quiz details 
if (!isset($_SESSION['current_question'])) {
    $_SESSION['current_question'] = 0;
    $_SESSION['score'] = 0;
}

// Fetch the current question
$sql = "SELECT * FROM question_new WHERE quiz_id='$quiz[quiz_id]' LIMIT 1 OFFSET " . $_SESSION['current_question'];
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    $question = $result->fetch_assoc();

    // Fetch the answers for the current question
    $sql = "SELECT * FROM answers_new WHERE question_id='$question[question_id]'";
    $answers_result = $connect->query($sql);
    $answers = $answers_result->fetch_all(MYSQLI_ASSOC);

} else {
    // No more questions, show the score
    header('location: grade.php');
}


// Getting total questions 
$sql = "SELECT * FROM question_new WHERE quiz_id='$quiz[quiz_id]'";
$total_questions = mysqli_num_rows(mysqli_query($connect, $sql));

$_SESSION["total_questions"] = $total_questions;

$sql = "SELECT * FROM answers_new WHERE question_id='$question[question_id]'";
$index = mysqli_fetch_assoc(mysqli_query($connect, $sql));

$timeLimit = $total_questions * 1.5;

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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    const quizDurationMinutes = <?php echo $timeLimit; ?>;
  </script>
  <script defer src="timer.js"></script>
</head>

<body id="take-quiz">
    <form method="post" style="<?php if($_SESSION["ongoing"] == true) : ?> display: none; <?php endif;  ?>">
        <!-- home  -->
         <div class="home">
            <a href="available-quizzes.php" class="home">Go back</a>
         </div>
        <div class="quiz-information">
            <p style="display: none;"><?php echo $quiz["quiz_id"]; ?></p>
            <div class="title">
                <h1><?php echo $quiz['title']; ?></h1>
            </div>
            <div class="creator">
                <h1><?php echo $quiz['creator']; ?></h1>
            </div>
            <div class="descr">
                <p>Description: <?php echo $quiz['description']; ?></p>
            </div>
            <div class="no-questions">
                <p>Number of questions: <?php echo $total_questions; ?></p>
            </div>
            <div class="time">
                <p>Allotted time: <?php echo $timeLimit; ?> minute(s)</p>
            </div>
            <?php if($_SESSION["role"] == "user"): ?>
                <button class="start-quiz" name="start-quiz">Start Quiz</button>
            <?php endif; ?>
        </div>
    </form>

    <?php if(isset($_POST["start-quiz"]) || is_bool($_SESSION["ongoing"])) : ?>
        <div id="timer"><?php echo $timeLimit; ?></div>
        <form action="result.php" method="POST" id="quiz-form">
            <div class="take-quiz-container">
                <p style="display: none;"><?php echo $question['id']; ?></p>
                <h4 class="question">Question <?php echo $index["question_number"] . " of " . $total_questions; ?></h4>
                <div class="question-container">
                    <p><?php echo $question['question_text']; ?> ?</p>
                </div>
                <div class="answer-buttons">
                    <ul class="answer-btn-list">
                        <?php foreach ($answers as $answer): ?> 
                            <li><input type="radio" name="answer" id="choice1" value="<?php echo $answer['id']; ?>"><?php echo $answer['answer']; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="quiz-state-buttons">
                    <?php if($index["question_number"] == $total_questions): ?>
                        <button type="submit" class="next_btn hide" name="submit_next">Submit Quiz</button>
                    <?php endif; ?>
                    <button type="submit" class="next_btn hide" name="submit_next" style="<?php if($index["question_number"] == $total_questions):?> display:none; <?php endif; ?>">Next</button>    
                    <button type="" class=" prev_btn hide" name="submit_prev" style="<?php if($index["question_number"] == 1):?> display:none; <?php endif; ?>">Prev</button>
                </div>
            </div>
        </form>
    <?php endif; ?>
</body>
</html> 
