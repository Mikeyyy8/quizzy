<?php

// Database connection
require_once "db.php";

// Initialize variables 
$username_err = $password_err = "";

session_start();  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];


    // Fetch user from the database
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($connect, $sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password == $user['password']) {
            $_SESSION["loggedin"] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['email'] = $user['email_address'];
            header('Location: index.php');
        } else {
            $password_err = "Incorrect password!";
        }
    } else {
        $username_err = "No such user!";
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
    <link rel="stylesheet" href="style.css">
    <title>sign in</title>
</head>


<body>
    <section id="login">
        <div class="card">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="login__register" class="login">
                <h2 class="header">SIGN IN</h2>
                <?php if ($username_err == true || $password_err == true): ?>
                <div class="uname-pass-err">
                <?php 
                    echo $username_err;
                    echo $password_err; 
                ?>
                </div>
                <?php endif; ?>

                <!-- REMEMBER TO CHANGE THE FORM -->
                <div class="username">
                    <input type="text" name="username" required placeholder="Username">
                </div>
                <div class="password">
                    <input type="password" name="password" required placeholder="Password">
                </div>
                <div class="button">
                    <button type="submit">Login</button>
                </div>
                <div class="link">
                    <a href="registration.php" class="link">Don't have an account?Sign up</a>
                </div>
            </form>
        </div>
    </section>
    
</body>

