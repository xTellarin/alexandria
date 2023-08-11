<?php
// Include the config.php file
require_once("../secure/config.php");

// Start a new session (or resume the existing one)
session_start();

// Create new mysqli connection
$db = new mysqli($host, $dbuser, $dbpassword, $database);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Check if form is submitted
if (!empty($_POST)) {
    // Get user input username and password
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Prepare SQL statement
    $stmt = $db->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);

    // Execute the prepared statement
    $stmt->execute();

    // Get the result from the select statement
    $result = $stmt->get_result();

    // Get the number of rows that match the username
    $num_of_rows = $result->num_rows;

    if ($num_of_rows > 0) {
        // Get the user_id and hashed password from the database and verify it with the entered password
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];
        $userId = $row['id'];

        if(password_verify($password, $hashedPassword)) {
            // Password matches and user is verified, start a session and store user id.
            $_SESSION["user_id"] = $userId;
            $_SESSION["username"] = $username;
            // Redirect to main page.
            header("Location: ./index.php");
            exit();
        } else {
            // Password doesn't match, display error message
            echo "Invalid login. Check your username or password.";
        }
    } else {
        // No user exists with inputted username
        echo "Invalid login. Check your username or password.";
    }
}
$db->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="styles.css">
<link rel="stylesheet" type="text/css" href="responsive.css">

<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Lato&family=PT+Mono&family=Poppins&display=swap" rel="stylesheet">

<title>Login - Alexandria</title>
<meta name="description" content="Login - Alexandria">
<meta name="author" content="Tellarin">
<link rel="icon" href="resources/favicon.ico" type="image/x-icon" />

<script src="https://kit.fontawesome.com/1bf421f337.js" crossorigin="anonymous"></script>
</head>

<body>



<div class="banner">
<h1 style="margin: 0;">Alexandria</h1>
<p style="margin: 0;">By Tellarin</p>
<i class="fa-solid fa-moon switcher" onclick="toggleTheme()"></i>
</div>



<h1>Hello!</h1>

        
        <div id="login-form">
        <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" maxlength="50" autocomplete="off" autocapitalize="off"><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" maxlength="255" autocomplete="off"><br><br>
        <input type="submit" value="Login" class="inputButton"><br>
        <a href="system/password_reset.php">Forgot your password?</a><br><br>
        <a href="system/create_account.php">Create Account</a>
        </form>
        
        </div>
        
        <script src="darkmode.js" defer></script>
        
        </body>
        </html>