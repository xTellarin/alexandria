<?php
// Include the config.php file
require_once("../../secure/config.php");

$conn = new mysqli($host, $dbuser, $dbpassword, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_GET['username'];

$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

// Echo the number of rows. JS will pick this up.
echo $result->num_rows;

$stmt->close();
$conn->close();
?>
