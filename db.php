<?php
$connect = mysqli_connect("localhost", "root", "", "quiz_app");

if(!$connect){
    die("Connection failed: " . mysqli_connect_error());
}

?>

