<?php
// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve the name and passkey from the form
    $comicTitle = $_POST['comicTitle'];
    $comicRating = $_POST['comicRating'];
    $comicTags = $_POST['comicTags'];
    $comicChapter = $_POST['comicChapter'];
    $comicLink = $_POST['comicLink'];
    $comicTeam = $_POST['comicTeam'];
    $currentDate = date('Y-m-d');   
    
    // Include the config.php file
    require_once("../../secure/config.php");
    
    $conn = new mysqli($host, $dbuser, $dbpassword, $database);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "UPDATE records SET rating = '$comicRating', tags = '$comicTags', chapters = '$comicChapter', link = '$comicLink', team = '$comicTeam', lastRead = '$currentDate' WHERE title = '$comicTitle'";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php"); // Redirect to main page after updating
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
} else {
    // Retrieve the comicTitle from the URL parameter
    $comicTitle = $_GET['comicTitle'];
    
// Include the config.php file
require_once("../../secure/config.php");

$conn = new mysqli($host, $dbuser, $dbpassword, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $sql = "SELECT * FROM records WHERE title = '$comicTitle'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Retrieve the existing comic data
        $comicRating = $row['rating'];
        $comicTags = $row['tags'];
        $comicChapter = $row['chapters'];
        $comicLink = $row['link'];
        $comicTeam = $row['team'];
        $currentDate = $row['lastRead'];
    } else {
        echo "Comic not found.";
        exit;
    }
    
    $conn->close();
}
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
<title>Edit Record - Alexandria</title>
<meta name="description" content="Edit Comic">
<meta name="author" content="TheGeekA69">
<link rel="icon" href="../resources/favicon.ico" type="image/x-icon" />

<script src="https://kit.fontawesome.com/1bf421f337.js" crossorigin="anonymous"></script>
<script src="../darkmode.js" defer></script>
</head>

<body>
<div class="banner">
<h1 style="margin: 0;">Alexandria</h1>
<p style="margin: 0;"></p>
<i class="fa-solid fa-moon switcher" onclick="toggleTheme()"></i>
</div>

<div style="height: 30px"></div>

<h1>Edit Record</h1>
<form id="editForm" method="POST" autocomplete="off">
<input type="text" name="comicTitle" placeholder="Comic Title" value="<?php echo $comicTitle; ?>" autocomplete="off" readonly>
<input type="text" name="comicTeam" placeholder="Team" value="<?php echo $comicTeam; ?>" autocomplete="off">
<input type="text" name="comicRating" placeholder="Rating" value="<?php echo $comicRating; ?>" autocomplete="off">
<input type="text" name="comicTags" placeholder="Tags" value="<?php echo $comicTags; ?>" autocomplete="off">
<input type="text" name="comicChapter" placeholder="Last Read Chapter" value="<?php echo $comicChapter; ?>" autocomplete="off">
<input type="text" name="comicLink" placeholder="Comic Link" value="<?php echo $comicLink; ?>" autocomplete="off">
<input type="text" name="currentDate" placeholder="Current Date" value="<?php echo $currentDate; ?>" autocomplete="off" readonly>
<input type="submit" name="submit" value="Submit">
</form>

</body>

</html>
