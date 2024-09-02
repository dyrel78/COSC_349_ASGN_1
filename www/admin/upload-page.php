<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>

<head>
    <title>Upload Drinks Page</title>

    <style>
        <?php include 'css/style.css'; ?><?php include 'css/navbar.css'; ?>@font-face {
            font-family: "montserrat";
            src: url(css/Montserrat-Regular.woff2);
        }

        body {
            font-family: 'montserrat', sans-serif;
        }
    </style>

</head>



<?php
// Start a session to track login status
session_start();

// Display any error message
// if (isset($error_message)) {
//     echo "<p class='error-message'>" . htmlspecialchars($error_message) . "</p>";
// }

// Database connection parameters
$db_host = '192.168.2.12';
$db_name = 'drinksDB';
$db_user = 'root';
$db_passwd = 'root_password';

$pdo_dsn = "mysql:host=$db_host;dbname=$db_name";

// Connect to the database
$pdo = new PDO($pdo_dsn, $db_user, $db_passwd);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check if the form has been submitted
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve username and password from form
?>



<body>
    <div class="container">
        <div class="navbar">
            <div class="navbar-logo">Drinks App</div>
            <ul class="navbar-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </div>

        <div class = "container">
            <h2>Login</h2>
            <form class ="form" action="login.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Type in your username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="*****" required>

                <input type="submit" value="Login">
            </form>


        </div>
        

            </div>


</body>

</html>