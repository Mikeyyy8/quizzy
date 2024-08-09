<?php

header('Content-Type: application/json');

// Database conection 
require_once "db.php";
session_start();


$username = $_SESSION['username'];

// Fetch data
$sql = ("SELECT username, AVG(score) AS average_score FROM grade WHERE username='$username' GROUP BY username");
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
// Return JSON response
echo json_encode($data);

?>