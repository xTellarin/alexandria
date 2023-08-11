<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="../styles.css">
<link rel="stylesheet" type="text/css" href="../responsive.css">
<link rel="stylesheet" href="https://use.fontawesome.com/5641fd34aa.css">


<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Lato&family=PT+Mono&family=Poppins&display=swap" rel="stylesheet">

<title>Chapter Updated!</title>
<meta name="description" content="Welcome to your reading list.">
<meta name="author" content="Tellarin">
<link rel="icon" href="../resources/favicon.ico" type="image/x-icon" />

<script src="https://kit.fontawesome.com/1bf421f337.js" crossorigin="anonymous"></script>
<script src="../darkmode.js" defer></script>
</head>


<body>


<div class="banner">
<h1 style="margin: 0;">Add a Record</h1>
<p style="margin: 0;"></p>
<i class="fa-solid fa-moon switcher" onclick="toggleTheme()"></i>
</div>

<div style="height: 30px"></div>


<?php
// Include the config.php file
require_once("../../secure/config.php");

$conn = new mysqli($host, $dbuser, $dbpassword, $database);


// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get the chapter and ID values from the form data
$chapters = $_POST["chapters"];
$id = $_POST["id"];
$currentDate = date('Y-m-d');  

// Update the chapter value in the database
$sql = "UPDATE records SET chapters='$chapters' , lastRead='$currentDate' WHERE id='$id'";
if ($conn->query($sql) === TRUE) {
  echo "<h1>Chapter updated successfully</h1>";
} else {
  echo "<h1>Error updating chapter: </h1>" . $conn->error;
}

// Close the database connection
$conn->close();
?>

<p>Redirecting...</p>
<script>
setTimeout(function() {
  window.location.href = "./";
}, 1500);
</script>
</body>
</html>