<?php

// Connecting the database
require_once "db.php";

//Initialize variables  

$username = $password = $error = $success =  "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);

    // Insert user into the database
    $sql = "INSERT INTO users (username, password, email_address) VALUES ('$username', '$password', '$email')";

    if (mysqli_query($connect, $sql)) {
        $success =  "Registration successful";
        header("Location: login.php");
    } else {
        $error = "Error: Cannot create account at this time";
    }

    mysqli_close($connect);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./image/ICONNN.svg" type="image/x-icon" class="icon">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>sign up</title>
</head>
<body>
    <section id="register">
        <div class="card">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="login__register">
                <h2 class="header">SIGN UP</h2>
                <div class="notify">
                    <?php
                        echo $success;
                        echo $error;
                    ?>
                </div>
                <div class="username">
                    <input type="text" name="username" required placeholder="Username">   
                </div>
                <div class="username">
                    <input type="password" name="password" required placeholder="Password">
                </div> 
                <div class="email">
                    <input type="email" name="email" required placeholder="Email">
                </div> 
                <div class="button">
                    <button type="submit">Register</button>
                </div>
                <div class="link">
                    <a href="login.php" class="link">Already have an account?Sign in</a>
                </div> 
            </form>
        </div>
    </section>
</body>
