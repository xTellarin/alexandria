<?php
// Include the config.php file
require_once("../../secure/config.php");

// Establish your connection
$mysqli = new mysqli($host, $dbuser, $dbpassword, $database);

// Checking connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check if form is submitted
if (!empty($_POST)) {
    // Prepare and bind
    $stmt = $mysqli->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);
    
    // Set data and execute
    $username = $_POST["username"]; // I assume your form fields names are 'username' and 'password'.
    $password = $_POST["password"];
    
    // Password should be hashed before storing in database.
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); 
    
    $stmt->execute();
    
    // After the account was created, it is a good practice to redirect the user to the login page.
    header('Location: ../login.php');
    
    $stmt->close();
}

$mysqli->close();
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

<title>Create Account - Tianyi</title>
<meta name="description" content="Create Account - Tianyi">
<meta name="author" content="Tellarin">
<link rel="icon" href="../resources/favicon.ico" type="image/x-icon" />

<script src="https://kit.fontawesome.com/1bf421f337.js" crossorigin="anonymous"></script>
</head>

<body>

<div class="banner"><a href="../login.php">
<h1 style="margin: 0;">Tianyi</h1></a>
<p style="margin: 0;">By Tellarin</p>
<i class="fa-solid fa-moon switcher" onclick="toggleTheme()"></i>
</div>



<h1>Account Creation</h1>
<p>Please create your account below:</p>


<div id="login-form">
<form method="post" action="">
<label for="username">Username:</label>
<input type="text" id="username" name="username" maxlength="50" autocomplete="off" autocapitalize="off" onblur="return checkUsername()">
<div id="usernameMessage"></div>
<label for="password">Password:</label>
<input type="password" id="password" name="password" maxlength="255" autocomplete="off"><br>
<label for="password">Retype Password:</label>
<input type="password" id="confirm_password" name="confirm_password" maxlength="255" autocomplete="off" onblur="return validate()">
<div id="message"></div><br><br>
<input type="submit" value="Create Account" class="inputButton">
</form>
</div>

<script src="../darkmode.js" defer></script>
<script>
function validate() {
    var password = document.getElementById("password").value;
    var confirm_password = document.getElementById("confirm_password").value;
    
    if (password != confirm_password) {
        document.getElementById("message").innerHTML = "Passwords do not match!";
        document.getElementById("password").style.borderColor = "red";
        document.getElementById("confirm_password").style.borderColor = "red";
        
        return false; // prevent form submission
    } else {
        document.getElementById("message").innerHTML = "";
        document.getElementById("password").style.borderColor = "green";
        document.getElementById("confirm_password").style.borderColor = "green";
        
        return true;
    }
}

// Check if username already exists
function checkUsername() {
    var username = document.getElementById("username").value;
    
    // Create a new AJAX request
    var xhr = new XMLHttpRequest();
    
    // Configure it: GET-request for the URL api/username_check.php
    xhr.open('GET', 'username_check.php?username=' + encodeURIComponent(username), true);
    
    xhr.onload = function() {
        if (this.status == 200) {
            // request completed successfully
            if (this.responseText == "0") {
                document.getElementById("usernameMessage").innerHTML = "";
                document.getElementById("username").style.borderColor = "green";
                // prevent form submission
                return false;
            } else {
                document.getElementById("usernameMessage").innerHTML = "Username already exists!";
                document.getElementById("username").style.borderColor = "red";
            }
        } else {
            console.error("Request failed");
        }
    };
    
    // Send the request
    xhr.send();
}

</script>

</body>
</html>