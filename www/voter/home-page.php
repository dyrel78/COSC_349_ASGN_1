<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>
<head>
    <title>Webserver test page</title>
        <style>
        th { text-align: left; }

        table, th, td {
        border: 2px solid grey;
        border-collapse: collapse;
        }

        th, td {
        padding: 0.2em;
        }
        ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        }
        </style>
        <link rel="stylesheet" type="text/css" href="styles.css">

</head>


<body>

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
                        echo "<li><a href='home-page.php'>Home</a></li>";
                        echo "<li><a href='logout.php'>Logout</a></li>";
                        echo "<li><a href='voting-page.php'>Contact</a></li>";
                        echo "</ul>";
                        echo "<p> You are currently logged in. </p>";
                     
                       } else {
                        echo "<ul>";
                        echo "<li><a href='home-page.php'>Home</a></li>";
                        echo "<li><a href='login.php'>News</a></li>";
                        echo "<li><a href='voting-page.php'>Contact</a></li>";
                        echo "</ul>";
                        echo "<p>You are currently logged out. <a href='login.php'>Login</a></p>";
                       
                       }

                        
                } catch(PDOException $e){
                        echo "Database error: " . htmlspecialchars($e->getMessage());
                }




        ?>    

<h1> Drink of the Week Home Page</h1>
<p> Welcome to the Drink of the Week Home Page. Here you can view the current drink of the week, and vote for the next drink of the week. </p>


</body>


</html>
