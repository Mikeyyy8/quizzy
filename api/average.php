<?php

header('Content-Type: application/json');

// Database conection 
require_once "../db.php";
session_start();


$username = $_SESSION['username'];
$course = isset($_GET['course']) ? $connect->real_escape_string($_GET['course']) : '';

// Fetch data
$sql = ("SELECT username, 
        quiz_id,
        DATE(date) as date,
        AVG(score) AS average_score 
        FROM grade WHERE username='$username' AND quiz_id='$course'
        GROUP BY quiz_id, DATE(date)
        ORDER BY DATE(date)");

$result = mysqli_query($connect, $sql);

// Check for query error
if (!$result) {
    die('Query error');
}

// Fetch data and encode as JSON
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Free result set and close connection
$result->free();
mysqli_close($connect);
// Return JSON response
echo json_encode($data);


?>