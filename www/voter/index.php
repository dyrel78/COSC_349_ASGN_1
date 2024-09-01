<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>
<head><title>Webserver test page</title>

</head>

<body>
<h1> Drink of the Week Home Page</h1>
<?php
                error_reporting(E_ALL);
                ini_set('display_errors', 1);
                $db_host   = '192.168.2.12';
                $db_name   = 'drinksDB';
                $db_user   = 'webuser';
                $db_passwd = 'password';

                $pdo_dsn = "mysql:host=$db_host;dbname=$db_name";

                session_start();

                try{
                        $pdo = new PDO($pdo_dsn, $db_user, $db_passwd);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    //check if user is logged in
                    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
                        echo "<ul>";
                        echo "<li><a href='index.php'>Home</a></li>";
                        echo "<li><a href='logout.php'>Logout</a></li>";
                        echo "<li><a href='voting-page.php'>Contact</a></li>";
                        echo "</ul>";
                        // echo "<h1> Drink of the Week Home Page</h1>";
                        // echo "<p> Welcome to the Drink of the Week Home Page. Here you can view the current drink of the week, and vote for the next drink of the week. </p>";
                        echo "<p> You are currently logged in. </p>";
                        // echo "<p> <a href='logout.php'>Logout</a> </p>";
                        echo "<p> <a href='voting-page.php'>Vote for the next drink of the week</a> </p>";
                       } else {
                        echo "<ul>";
                        echo "<li><a href='index.php'>Home</a></li>";
                        echo "<li><a href='login.php'>News</a></li>";
                        echo "<li><a href='voting-page.php'>Contact</a></li>";
                        echo "</ul>";
                        // echo "<h1> Drink of the Week Home Page</h1>";
                        // echo "<p> Welcome to the Drink of the Week Home Page. Here you can view the current drink of the week, and vote for the next drink of the week. </p>";
                        echo "<p>You are currently logged out. <a href='login.php'>Login</a></p>";
                        // echo "<p> <a href='login.php'>Login</a> </p>";
                        // echo "<p> <a href='voting-page.php'>Vote for the next drink of the week</a> </p>";
                       }

                        
                } catch(PDOException $e){
                        echo "Database error: " . htmlspecialchars($e->getMessage());
                }




        ?>    

<p> Welcome to the Drink of the Week Home Page. Here you can view the current drink of the week, and vote for the next drink of the week. </p>

</body>
</html>
