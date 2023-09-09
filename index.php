<?php
// Checks for active session
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ./login.php');
    exit;
}
$userId = $_SESSION['user_id'];
$username = $_SESSION['username'];

// destroy the current session
function logout() {
    // Start the session
    session_start();
    // Unset all of the session variables
    $_SESSION = array();
    // Destroy the session
    session_destroy();
    // Redirect to the login page
    header('Location: login.php');
    exit;
}
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
    
    <title>Home - Tianyi</title>
    <meta name="description" content="Welcome to your library.">
    <meta name="author" content="Tellarin">
    <link rel="icon" href="./resources/favicon.ico" type="image/x-icon" />

    <script src="https://kit.fontawesome.com/1bf421f337.js" crossorigin="anonymous"></script>
</head>

<body>

<div class="banner">
        <h1 style="margin: 0;">Welcome</h1>
        <p style="margin: 0;">Good to see you, <?php echo $username; ?>!</p>
        <i class="fa-solid fa-moon switcher" onclick="toggleTheme()"></i>
</div>

   

    <h1>Hi <?php echo $username; ?></h1>

    <p>Click below to access your library.</p>
    
    <div class="row"> 
        <div class="column"> 
            <button type="submit" onclick="location.href='./tianyi/'">Library</button>
        </div>
    </div>
    <div style="height: 20px"></div>

    <p>A question or suggestion? Feel free to submit a pull request or file an issue on the <a href="">GitHub repo</a>. Please use the discussions tab for everything else!<br>
    You can also shoot me an <a href=""mailto:hello@tellarin.dev>email</a> or message me on Discord: Tellarin#0069.</p>
    <p style="">If you need to, you can also <a href="system/logout.php">logout</a>.</p>


<script src="darkmode.js" defer></script>
</body>
</html>