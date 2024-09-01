<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>
<head>
    <title>Drink of the Week Voting Page</title>
    <style>
<?php include 'css/vote-page.css'; ?>
</style>

</head>
<body className = vote-body>
<div className="card-container">
    
    <div className="card-grid">
        <?php 
         error_reporting(E_ALL);
         ini_set('display_errors', 1);
         $db_host   = '192.168.2.12';
         $db_name   = 'drinksDB';
         $db_user   = 'webuser';
         $db_passwd = 'password';

         $pdo_dsn = "mysql:host=$db_host;dbname=$db_name";

         $pdo = new PDO($pdo_dsn, $db_user, $db_passwd);
         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $q = $pdo->query("SELECT * FROM Drinks");

            while ($row = $q->fetch()) {
                echo "<div class='card-item'>";
                echo "<h3>" . htmlspecialchars($row["name_of_drink"]) . "</h3>";
                echo "<p>" . htmlspecialchars($row["descripton"]) . "</p>";
                echo "<p>Price: $" . htmlspecialchars($row["price"]) . "</p>";
                echo "<p>Rating: " . htmlspecialchars($row["rating"]) . "</p>";
                echo "<p>Likes: " . htmlspecialchars($row["likes"]) . "</p>";
                echo "</div>";
            }
        ?>


    </div>

       
</div>

</body>

</html>

