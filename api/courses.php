<?php
header('Content-Type: application/json');

require_once "../db.php";

// SQL query to fetch distinct courses
$sql = "SELECT DISTINCT quiz_id FROM grade";
$result = $connect->query($sql);

// Fetch data and encode as JSON
$courses = array();
while ($row = $result->fetch_assoc()) {
    $courses[] = $row['quiz_id'];
}

echo json_encode($courses);

// Close connection
$result->free();
$connect->close();
?>
