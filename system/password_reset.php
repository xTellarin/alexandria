<?php
// Prepare username error message
$error_message = "";

// Include the config.php file
require_once("../../secure/config.php");

$conn = new mysqli($host, $dbuser, $dbpassword, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    if($password != $confirm_password) {
       pass;
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        // Check if the username exists
        if ($result->num_rows === 0) {
            // If the username does not exist
            $error_message = "Username does not exist.";

        } else {
            // If the username exists then update the password
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param('ss', $hashed_password, $username);
            
            if ($stmt->execute() === TRUE) {
                echo "Password updated successfully."; 
                sleep(1);
                header("Location: ../login.php");
            } else {
                echo "Error: " . $stmt->error;
            }
        }
        
        $stmt->close(); 
    }
}

$conn->close();


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

<title>Reset Password - Alexandria</title>
<meta name="description" content="Password Reset - Alexandria">
<meta name="author" content="Tellarin">
<link rel="icon" href="../resources/favicon.ico" type="image/x-icon" />

<script src="https://kit.fontawesome.com/1bf421f337.js" crossorigin="anonymous"></script>
</head>

<body>



<div class="banner"><a href="../login.php">
<h1 style="margin: 0;">Alexandria</h1></a>
<p style="margin: 0;">By Tellarin</p>
<i class="fa-solid fa-moon switcher" onclick="toggleTheme()"></i>
</div>



<h1>Reset Password</h1>

<div id="login-form">
<form method="post" action="" onsubmit="return okMessage()">

<label for="username">Username:</label>
<input type="text" id="username" name="username" maxlength="50" autocomplete="off" autocapitalize="off">
<div id="error-message" style="color: red;">
    <?php echo $error_message; ?>
</div>


<label for="password">New Password:</label>
<input type="password" id="password" name="password" maxlength="255" autocomplete="off"><br>

<label for="confirm_password">Confirm New Password:</label>
<input type="password" id="confirm_password" name="confirm_password" maxlength="255" autocomplete="off" onblur="return validate()"><br><br>
<div id="message"></div>
<br>
<button type="submit" name="submit" style="margin: 0;">Reset Password</button>
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
        document.getElementById("password").style.borderColor = "";
        document.getElementById("confirm_password").style.borderColor = "";
        
        return true;
    }
}
function okMessage() {
    var password = document.getElementById("password").value;
    var confirm_password = document.getElementById("confirm_password").value;
    
    if (password != confirm_password && document.getElementById("error-message").innerHTML == "") {
        document.getElementById("message").innerHTML = "Passwords do not match!";
        document.getElementById("password").style.borderColor = "red";
        document.getElementById("confirm_password").style.borderColor = "red";
        
        return false; // prevent form submission
    } else {
        document.getElementById("message").innerHTML = "Password updated successfully!";
        document.getElementById("password").style.borderColor = "";
        document.getElementById("confirm_password").style.borderColor = "";
        
        return true;
    }
}
function checkUsername() {
    var password = document.getElementById("password").value;
    var confirm_password = document.getElementById("confirm_password").value;
    
    if (password != confirm_password) {
        document.getElementById("message").innerHTML = "Passwords do not match!";
        document.getElementById("password").style.borderColor = "red";
        document.getElementById("confirm_password").style.borderColor = "red";
        
        return false; // prevent form submission
    } else {
        document.getElementById("message").innerHTML = "Password updated successfully!";
        document.getElementById("password").style.borderColor = "";
        document.getElementById("confirm_password").style.borderColor = "";
        
        return true;
    }
}
</script>


</body>
</html>