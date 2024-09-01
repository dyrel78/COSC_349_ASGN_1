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
    <!-- <link rel="stylesheet" href="style.css"> -->

<style>

@font-face {
    font-family: "montserrat";
    src: url(Montserrat-Regular.woff2);
}

body {
    /* font-family: Arial, sans-serif; */
    
    font-family: "montserrat";
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    height: 100vh;
}


.card-container {
    grid-template-columns: 1fr;
    grid-template-rows: 1fr;  
    padding-top: 20px;
    margin-top: 20px;
    width  : 50%;
    max-width: 1200px;
  }
  
   @media (min-width: 600px) {
    .card-container {
       display: grid;
      grid-template-columns: 200px 1fr;
      gap: 20px; 
      grid-template-columns: 1fr;
    padding-top: 20px;
    margin-top: 20px;
    width  : 50%;
    max-width: 1200px;
    }
  } 
  
  .card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    grid-auto-rows: minmax(250px, auto);
    gap: 20px;
  }
  
  .card-item {
    display: flex;
    flex-direction: column;
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 5px;
    background-color: #f9f9f9;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    width: 50%;
  }





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

