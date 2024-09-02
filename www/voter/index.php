<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>

<head>
    <title>Webserver test page</title>

    <style>
        <?php include 'css/style.css'; ?>
        <?php include 'css/navbar.css'; ?>@font-face {
            font-family: "montserrat";
            src: url(css/Montserrat-Regular.woff2);
        }

        body {
            font-family: 'montserrat', sans-serif;
        }
    </style>
</head>


<body>
    <div class="container">
        <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        $db_host   = '192.168.2.12';
        $db_name   = 'drinksDB';
        $db_user   = 'webuser';
        $db_passwd = 'password';

        $pdo_dsn = "mysql:host=$db_host;dbname=$db_name";

        session_start();

        try {
            $pdo = new PDO($pdo_dsn, $db_user, $db_passwd);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //check if user is logged in
            if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
                echo "<nav class='navbar'>";
                echo "<div class='navbar-logo'>Drinks App</div>";
                echo "<ul class='navbar-links'>";
                echo "<li><a href='index.php'>Home</a></li>";
                echo "<li><a href='logout.php'>Logout</a></li>";
                echo "</ul>";
                echo "</nav>";
                // echo "<p> You are currently logged in. </p>";                       
                // echo "<p> <a href='voting-page.php'>Vote for the next drink of the week</a> </p>";

            } else {
                echo "<nav class='navbar'>";
                echo "<div class='navbar-logo'>Drinks App</div>";
                echo "<ul class='navbar-links'>";
                echo "<li><a href='index.php'>Home</a></li>";
                echo "<li><a href='login.php'>Login</a></li>";
                echo "</ul>";
                echo "</nav>";
                // echo "<p>You are currently logged out. <a href='login.php'>Login</a></p>";
            }
        } catch (PDOException $e) {
            echo "Database error: " . htmlspecialchars($e->getMessage());
        }




        ?>


        <div class = "text-container" >
        <p> Welcome to the Drink of the Week Home Page. Here you can view the current drink of the week, and vote for the next drink of the week. </p>

            <?php
               if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
                echo "<p> You are currently logged in. </p>";                       
                echo "<p> <a href='voting-page.php'>Vote for the next drink of the week</a> </p>";
               }else {
                echo "<p>You are currently logged out. You can log in at <a href='login.php'>Login</a></p>";
               }



            ?>
               
            
        </div>

        <div class="footer"> 
            <p> &copy; 2024 Drink of the Week </p>
            <p> Made by Dyrel Lumiwes </p>
            

        </div>
    </div>



</body>

</html>