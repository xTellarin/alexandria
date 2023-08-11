<?php
// Checks for active session
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
$userId = $_SESSION['user_id'];
$username = $_SESSION['username'];
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

<title>Alexandria</title>
<meta name="description" content="Welcome to your library.">
<meta name="author" content="Tellarin">
<link rel="icon" href="../resources/favicon.ico" type="image/x-icon" />

<script src="https://kit.fontawesome.com/1bf421f337.js" crossorigin="anonymous"></script>
<script src="../darkmode.js" defer></script>
</head>
<body>

<div class="banner"><a href="../">
<h1 style="margin: 0;">Library</h1> </a>
<p style="margin: 0;"></p>
<i class="fa-solid fa-moon switcher" onclick="toggleTheme()"></i>
</div>

<div style="height: 30px"></div>

<input type="text" id="tagSearch" placeholder="Search by tag...">
<input type="text" id="teamSearch" placeholder="Search by team...">

<form id="updateForm" method="post" action="updateChapter.php">
<input type="hidden" id="rowId" name="id" value="">
<label for="lastChapter">Last chapter read:</label>
<input type="text" id="lastChapter" name="chapters" placeholder="01" style="width:50px;" autocomplete="off">
</form>


<table>
<thead>
<tr>
<th>Title</th>
<th>Chapter</th>
<th id='teamHeader'>Team</th>
<th id='ratingHeader'>Rating</th>
<th id='tagsHeader'>Tags</th>
<th>Last Read On</th>
<th>Update Chapter</th>
<th>Edit Info</th>
</tr>
</thead>
<tbody>


<?php
// Include the config.php file
require_once("../../secure/config.php");

$conn = new mysqli($host, $dbuser, $dbpassword, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from the database
$sql = "SELECT * FROM records WHERE userID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();

// Generate an HTML table with the data
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr data-title='" . $row["title"] . "'>";
        echo "<td><a href='" . $row["link"] . "' target='_blank'>" . $row["title"] . "</a></td>";
        echo "<td>" . $row["chapters"] . "</td>";
        echo "<td class='comic-team'>" . $row["team"] . "</td>";
        echo "<td class='comic-rating'>" . $row["rating"] . "</td>";
        echo "<td class='comic-tags'>" . $row["tags"] . "</td>";
        echo "<td>" . $row["lastRead"] . "</td>";
        echo "<td class='updateChapterButton'><button data-id='" . $row["id"] . "' onclick='updateChapter(" . $row["id"] . ")'>Update</button></td>";
        echo '<td class="editRowButton"><button type="button" onclick="editRow(this)">Edit</button></td>';
        echo "</tr>";
    }
    echo "</tbody></table>";
    
} else {
    echo "0 results";
}

// Reset the result set pointer to the beginning
mysqli_data_seek($result, 0);

// Close the database connection
$conn->close();
?>


<button type="button" onclick="window.location.href = './add_comic.php'" id="newRowButton">Add a new record</button>
<div style="margin-top: 30px;"></div>



















<script defer>
function updateChapter(rowId) {
    // Get the new value of the lastChapter element
    var newChapter = document.getElementById("lastChapter").value;
    
    // Set the value of the rowId input element
    document.getElementById("rowId").value = rowId;
    
    // Submit the form
    document.getElementById("updateForm").submit();
}
function editRow(button) {
    var row = button.parentNode.parentNode;
    var title = row.getAttribute('data-title');
    
    // Redirect to the edit_comic.php page with the comicTitle as a parameter
    window.location.href = "edit_comic.php?comicTitle=" + encodeURIComponent(title);
}
</script>

<script src="script.js" defer></script>



<?php
// Include the config.php file
require_once("../../secure/config.php");

$conn = new mysqli($host, $dbuser, $dbpassword, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the "chapter" and "id" parameters are set in the $_POST superglobal
if (isset($_POST['chapters']) && isset($_POST['id'])) {
    // Get the new value of the lastChapter element
    $newChapter = $_POST['chapters'];
    // Get the current date
    $currentDate = date('Y-m-d');  
    
    // Sanitize the new value
    $newChapter = $conn->real_escape_string($newChapter);
    
    // Get the ID of the row
    $rowId = $_POST['id'];
    
    // Sanitize the ID of the row
    $rowId = $conn->real_escape_string($rowId);
    
    // Update the database with the new value and the ID of the row
    $sql = "UPDATE records SET chapters='$newChapter' , lastRead=$currentDate WHERE id='$rowId'";
    if ($conn->query($sql) === TRUE) {
        echo "Chapter updated successfully";
    } else {
        echo "Error updating chapter: " . $conn->error;
    }
} else {
    die('');
}

// Close the database connection
$conn->close();
?>
</body>
</html>