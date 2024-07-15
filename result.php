<?php
require_once 'db.php';
session_start();

// Fetch available quizzes
$sql = "SELECT * FROM quiz_new";
$quizzes_result = $connect->query($sql);
$quiz = $quizzes_result->fetch_assoc();

if (isset($_POST["submit_next"])) {
    $selected_answer_id = $_POST['answer'];

    // Check if the selected answer is correct
    $sql = "SELECT is_correct FROM answers_new WHERE id=" . $selected_answer_id;
    $result = $connect->query($sql);
    $answer = $result->fetch_assoc();

    if ($answer['is_correct']) {
        $_SESSION['score']++;
    }

    // Move to the next question
    $_SESSION['current_question']++;

    // Redirect to the quiz page
    header('Location: take-quiz.php?id=' . $_SESSION["id"]);

}elseif(isset($_POST["submit_prev"])){
    $_SESSION['score']--;
    $_SESSION['current_question']--;
}

header('Location: take-quiz.php?id=' . $_SESSION["id"]);
exit;
?>
