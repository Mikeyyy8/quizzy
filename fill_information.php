<?php

require_once "db.php";
session_start();

$entry = $_SESSION["quiz_id"];


if($_SERVER["REQUEST_METHOD"] == 'POST'){
    $question_number = $_POST["question_number"] ;
    $question_text = $_POST["question_text"] ;
    $correct_choice = $_POST["correct"] ;
    $question_id = trim($entry.$question_number);

    // CHOICE ARRAY
    $choice = [];
    $choice[1] = $_POST["choice1"];
    $choice[2] = $_POST["choice2"];
    $choice[3] = $_POST["choice3"];
    $choice[4] = $_POST["choice4"];

    // QUERYING THE QUESTIONS TABLE

    $sql = "INSERT INTO question_new (question_text, quiz_id, question_id) VALUES ('$question_text', '$entry', '$question_id')";

    if(mysqli_query($connect, $sql)){
        foreach($choice as $answer => $value){
            if($value != ""){
                if($correct_choice == $answer){
                    $is_correct = 1;
                } else{
                    $is_correct = 0;
                }


                $sql = "INSERT INTO answers_new (question_id, question_number, is_correct, answer) VALUES ('$question_id', '$question_number', '$is_correct', '$value')";

                if(mysqli_query($connect, $sql)){
                    $message = "Question has been added successfully";
                }else{
                    die("Could not execute");
                }
            }
        }
    }

    $sql = "SELECT * FROM question_new WHERE quiz_id='$entry'";
    $questions = mysqli_query($connect, $sql);
    $total = mysqli_num_rows($questions);
    $next = $total + 1;

    mysqli_close($connect);
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
</head>


<body id="make-quiz">
    <div class="home">
        <a href="index.php" class="back">Go home</a>
    </div>
    <form method="POST">
        <div class="question_container">
            <?php if(isset($message)) : ?>
                <div class="message">
                    <p><?php echo $message; ?></p>
                </div>
            <?php endif; ?>
            <div class="question">
                Question: <input type="text" name="question_text" required><br>
            </div>
            <div class="question-number">
                <label>Number:</label><input type="number" name="question_number" id="number" value="<?php echo $next; ?>">
            </div>
            <!-- <div class="type">
                <label for="type">Type:</label> 
                <select name="questions_type">
                    <option value="multiple_choice">Multiple Choice</option>
                    <option value="true_false">True/False</option>
                </select>
            </div> -->
            <div class="answers">
                <ul>
                    <li><label>Choice 1:</label><input type="text" name="choice1"></li>
                    <li><label>Choice 2:</label><input type="text" name="choice2"></li>
                    <li><label>Choice 3:</label><input type="text" name="choice3"></li>
                    <li><label>Choice 4:</label><input type="text" name="choice4"></li>
                </ul>
            </div>
            <div class="correct">
                <label>Correct:</label><input type="number" name="correct" id="correct">
            </div>
            <div class="submit-btn">
                <button type="submit" name="quiz_submit">Submit</button>
            </div>
        </div>
    </form>
</body>

</html>
