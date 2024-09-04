
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

try{
$db_host = '192.168.2.12';
$db_name = 'drinksDB';
$db_user = 'admin_account';
$db_passwd = 'strong_admin_password';

$pdo_dsn = "mysql:host=$db_host;dbname=$db_name";

// try {
    // Connect to the database
    $pdo = new PDO($pdo_dsn, $db_user, $db_passwd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form has been submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Retrieve username and password from form

            $drink_name = trim($_POST['name_of_drink']);
            $description = trim($_POST['description']);
            $price = trim($_POST['price']);

            $query = $pdo ->prepare("INSERT INTO Drinks (name_of_drink, descripton, price) VALUES (?, ?, ?)");
            $query->execute([$drink_name, $description, $price]);
            $query->closeCursor();
            $message = 'Drink uploaded successfully.';


        } else {
            $error_message = 'Please fill out all fields.';
        }

    } catch (PDOException $e) {
        echo "Database error: " . htmlspecialchars($e->getMessage());
        $error_message = 'Error uploading drink.';
    }


        ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Upload Drink </title>
    <style>
<?php include 'css/style.css'; ?>
<?php include 'css/navbar.css'; ?>

    body{

        padding: 0px;
        margin: 0px;
    }
</style>
</head>
<body>
    <div class="container">

        <nav class="navbar">
            <div class="navbar-logo">Drink of the Week</div>
            <ul class="navbar-links">
                <li><a href="admin-page.php">Home</a></li>
                <!-- <li><a href="logout.php">Logout</a></li> -->
                <!-- <li><a href="voting-page.php">Vote for the next drink of the week</a></li> -->
            </ul>
        </nav>

        <div class="login-container">
            <h2>Upload Drink</h2>
            <form action="upload-page.php" method="post">
                <label for="name_of_drink">Drink Name:</label>
                <input type="text" id="name_of_drink" name="name_of_drink" required>
                
                <label for="description">Description:</label>
                <input type="text" id="description" name="description" required>

                <label for = "price">Price:</label>
                <input type = "text" id = "price" name = "price" required>

                <!-- <label for = "image"> Image:</label>
                <input type = "text" id = "image" name = "image" required> -->
                
                <input type="submit" value="Upload Drink">
            </form>
        </div>
        <?php
        if (isset($error_message)) {
            echo "<p class='" . (isset($error) ? 'error-message' : 'success-message') . "'>" . htmlspecialchars($error_message) . "</p>";
        }
        ?>


        <footer class="footer">
            <p>Drink of the Week</p>
        </footer>
    </div>
   
</body>
</html>
