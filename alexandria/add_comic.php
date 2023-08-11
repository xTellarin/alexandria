<?php
// Checks for active session
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
$userId = $_SESSION['user_id'];

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve the form data
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

  // Prepare an SQL statement
$stmt = $conn->prepare(
    "INSERT INTO records 
    (title, rating, tags, chapters, link, team, lastRead, userID)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
);

// Check if the statement prepared successfully
if ($stmt === false) {
    die('prepare() failed: ' . htmlspecialchars($conn->error));
}


    // Bind parameters
    $stmt->bind_param(
        'sssssssi', 
        $comicTitle, 
        $comicRating, 
        $comicTags, 
        $comicChapter, 
        $comicLink, 
        $comicTeam, 
        $currentDate, 
        $userId
    );

    // Execute the statement
    if ($stmt->execute() === TRUE) {
        echo "Record added successfully.";
        sleep(5);
        header("Location: ./");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
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

<title>Add Record - Alexandria</title>
<meta name="description" content="Add a record to your library.">
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


<h1>Add a record</h1>
<form id="addForm" method="POST" autocomplete="off">
<input type="text" name="comicTitle" placeholder="Comic Title" autocomplete="off">
<input type="text" name="comicTeam" placeholder="Team" autocomplete="off">
<input type="text" name="comicRating" placeholder="Rating" autocomplete="off">
<input type="text" name="comicTags" placeholder="Tags" autocomplete="off" id="tags">
<input type="text" name="comicChapter" placeholder="Last Read Chapter" autocomplete="off">
<input type="text" name="comicLink" placeholder="Comic Link" autocomplete="off">
<br>
<input type="submit" name="submit" value="Submit">
</form>

<div style="height: 20px"></div>

<h2>About tags</h2>
<p>Type in any tag you'd like to use later to filter your library. You also have those to get you started (click them!):</p>
<div class="tags-table">
<div class="tags-row">
<button class="autofill-button" onclick="autofill('Action')">Action</button>
<button class="autofill-button" onclick="autofill('Bad Translation')">Bad Translation</button>
<button class="autofill-button" onclick="autofill('Best')">Best</button>
<button class="autofill-button" onclick="autofill('Comedy')">Comedy</button>
<button class="autofill-button" onclick="autofill('Drama')">Drama</button>
</div>
<div class="tags-row">
<button class="autofill-button" onclick="autofill('Dungeon')">Dungeon</button>
<button class="autofill-button" onclick="autofill('Fantasy')">Fantasy</button>
<button class="autofill-button" onclick="autofill('Hidden MC')">Hidden MC</button>
<button class="autofill-button" onclick="autofill('Hunter')">Hunter</button>
<button class="autofill-button" onclick="autofill('Magic')">Magic</button>
</div>
<div class="tags-row">
<button class="autofill-button" onclick="autofill('Manga')">Manga</button>
<button class="autofill-button" onclick="autofill('Modern')">Modern</button>
<button class="autofill-button" onclick="autofill('Multiple MC')">Multiple MC</button>
<button class="autofill-button" onclick="autofill('Murim')">Murim</button>
<button class="autofill-button" onclick="autofill('Mythology')">Mythology</button>
</div>
<div class="tags-row">
<button class="autofill-button" onclick="autofill('OP')">OP</button>
<button class="autofill-button" onclick="autofill('Original')">Original</button>
<button class="autofill-button" onclick="autofill('Ranker')">Ranker</button>
<button class="autofill-button" onclick="autofill('Regression')">Regression</button>
<button class="autofill-button" onclick="autofill('Reincarnation')">Reincarnation</button>
</div>
<div class="tags-row">
<button class="autofill-button" onclick="autofill('School')">School</button>
<button class="autofill-button" onclick="autofill('Serious')">Serious</button>
<button class="autofill-button" onclick="autofill('Slow Story')">Slow Story</button>
<button class="autofill-button" onclick="autofill('Video Game')">Video Game</button>
<button class="autofill-button" onclick="autofill('Villain')">Villain</button>
</div>
<div class="tags-row">
<button class="autofill-button" onclick="autofill('Wuxia')">Wuxia</button>
</div>
</div>

<p>Have a tag you want me to add? Send me an <a href='mailto:hello@tellarin.dev'>email</a>.</p>

<style>
.autofill-button{
    margin:0;
}
.tags-table{
    margin-left:25%;
    margin-right: 25%;
    display: flex;
    flex-wrap: wrap;
    flex-direction: row;
}

</style>
<script>
    function autofill(word) {
  var textField = document.getElementById("tags");
  textField.value += word + ", ";
}
</script>
</body>
</html>
