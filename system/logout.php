<?php
// Checks for active session
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
$userId = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="../styles.css">
<link rel="stylesheet" type="text/css" href="../responsive.css">

<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Lato&family=PT+Mono&family=Poppins&display=swap" rel="stylesheet">

<title>Logged Out</title>
<meta name="description" content="">
<meta name="author" content="Tellarin">
<link rel="icon" href="../resources/favicon.ico" type="image/x-icon" />

<script src="https://kit.fontawesome.com/1bf421f337.js" crossorigin="anonymous"></script>
<script src="../darkmode.js" defer></script>
</head>

<body>

<div class="banner">
<h1 style="margin: 0;">Tianyi</h1>
<p style="margin: 0;">By Tellarin</p>
<i class="fa-solid fa-moon switcher" onclick="toggleTheme()"></i>
</div>

<h1>See you around!</h1>
<p>You have been logged out successfully.</p>
<p><a href="../login.php">Login again</a></p>    

<?php
session_destroy();
exit;
?>
</body>
</html>