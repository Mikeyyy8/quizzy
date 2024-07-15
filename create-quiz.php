<?php

// Database connection
require_once "db.php";

session_start();
if ($_SESSION['role'] != 'admin') {
    header('Location: index.php');
    exit;
}

$id = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $creator = $_POST['creator'];
    $description = $_POST['description'];
    $questions = $_POST['no_of_questions'];
    $time = $_POST['time'];

    // Insert quiz into the database
    $sql = "INSERT INTO quizzes (title, creator, description, no_of_questions, allotted_time) VALUES ('$title', '$creator', '$description', '$questions', '$time')";
    if (mysqli_query($connect, $sql)) {
        $quiz_id = $connect->insert_id;

        // Insert questions and answers
        foreach ($_POST['questions'] as $question) {
            $question_text = $question['text'];
            $question_type = $question['type'];
            $sql = "INSERT INTO questions (quiz_id, question_text, question_type) VALUES ('$quiz_id', '$question_text', '$question_type')";
            if ($connect->query($sql) === TRUE) {
                $question_id = $connect->insert_id;

                foreach ($question['answers'] as $answer) {
                    $answer_text = $answer['text'];
                    $is_correct = $answer['correct'] ? 1 : 0;
                    $sql = "INSERT INTO answers (question_id, answer_text, is_correct) VALUES ('$question_id', '$answer_text', '$is_correct')";
                    $connect->query($sql);
                }
            }
        }

        echo "Quiz created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $connect->error;
    }

    $connect->close();
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

<body id="create-quiz-body">

<div class="create-quiz">
    <div class="container">
        <form method="POST">
            <div class="quiz-information">
                <div class="title">
                    Title:<input type="text" name="title" required class="information">
                </div>
                <div class="creator">
                    Lecturer:<input type="text" name="creator" required class="information" value="<?php echo $id; ?>">
                </div>
                <div class="description">
                    Description:<textarea name="description" required></textarea>
                </div>
                <div class="no-questions">
                    Number of questions:<input type="number" name="no_of_questions" required ></input>
                </div>
                <div class="time">
                    Alloted time:<input type="number" name="time" required placeholder="eg: 20 mins"></input>
                </div>
            </div>

            <div id="questions">
                <!-- Questions will be added here dynamically -->
            </div>
            <div class="add-button">
                <button type="button" onclick="addQuestion()">Add Question</button>
            </div>
            <div class="submit">
                <button type="submit">Create Quiz</button>
            </div>
        </form>
    </div>
</div>
<div class="home">
    <a href="index.php" class="home">Go back</a>
</div>
</body>
<script>
function addQuestion() {
    const questionsDiv = document.getElementById('questions');
    const questionDiv = document.createElement('div');
    questionDiv.innerHTML = `
    <div class="question-div">
        Question: <input type="text" name="questions_text" required><br>
        Type: 
        <select name="questions_type">
            <option value="multiple_choice">Multiple Choice</option>
            <option value="true_false">True/False</option>
        </select><br>
        <div class="answers">
            <!-- Answers will be added here dynamically -->
        </div>
        <button type="button" onclick="addAnswer(this)">Add Answer</button>
    </div>
    `;
    questionsDiv.appendChild(questionDiv);
}

function addAnswer(button) {
    const answersDiv = button.previousElementSibling;
    const answerDiv = document.createElement('div');
    answerDiv.innerHTML = `
        Answer: <input type="text" name="questions[][answers][][text]" required>
        Correct: <input type="checkbox" name="questions[][answers][][correct]"><br>
    `;
    answersDiv.appendChild(answerDiv);
}
</script>
