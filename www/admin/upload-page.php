
<?php
     
        // session_start();
        // if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        //     header('Location: create-account.php');
        //     exit;
        // }

        session_start(); 
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        // Database connection parameters
$db_host = '192.168.2.12';
$db_name = 'drinksDB';
$db_user = 'admin_account';
$db_passwd = 'strong_admin_password';

$pdo_dsn = "mysql:host=$db_host;dbname=$db_name";

// try {
    // Connect to the database
    $pdo = new PDO($pdo_dsn, $db_user, $db_passwd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // // Check if the form has been submitted
    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //     // Retrieve username and password from form
    // } else if ($_SERVER[''] === '') {
        
    // }

        ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Upload Drink </title>
    <style>
<?php include 'css/style.css'; ?>
</style>
</head>
<body>
    <div class="container">
        <h2>Upload Drink</h2>
        <form action="upload-page.php" method="post">
            <label for="drink_name">Drink Name:</label>
            <input type="text" id="drink_name" name="drink_name" required>
            
            <label for="description">Description:</label>
            <input type="text" id="description" name="description" required>

            <label for = "price">Price:</label>
            <input type = "text" id = "price" name = "price" required>

            <!-- <label for = "image"> Image:</label>
            <input type = "text" id = "image" name = "image" required> -->
            
            <input type="submit" value="Upload Drink">
        </form>
        <?php
        if (isset($message)) {
            echo "<p class='" . (isset($error) ? 'error-message' : 'success-message') . "'>" . htmlspecialchars($message) . "</p>";
        }
        ?>
    </div>
   
</body>
</html>
