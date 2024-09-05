<?php

session_start();
?>

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
        .text-container >h3{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 50px;
        } 

        .drink-of-the-week-container{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: 20px;

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
            align-items: center;
            align-content: center;
            box-sizing: border-box;
            margin: 10px;
            align-self: center;

            
        }

        .card-item:hover {
            background-color: #f4f4f4;
        }

        .card-item h3{
            font-size: 1.25rem;
            margin-bottom: 20px;
            color: #333;
        }

        .card-item button{
            padding: 10px 20px;
            border: none;
            background-color: #007bff;
            color: #fff;
            font-size: 1rem;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 20px;
            width: 80%;
            align-self: center;
        }

        .card-item button:hover{
            background-color: #adb0b3;
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

 

        try {
            $pdo = new PDO($pdo_dsn, $db_user, $db_passwd);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //check if user is logged in
            if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
                echo "<nav class='navbar'>";
                echo "<div class='navbar-logo'>Drink of the Week</div>";
                echo "<ul class='navbar-links'>";
                echo "<li><a href='index.php'>Home</a></li>";
                echo "<li><a href='logout.php'>Logout</a></li>";
                echo "</ul>";
                echo "</nav>";
                // echo "<p> You are currently logged in. </p>";                       
                // echo "<p> <a href='voting-page.php'>Vote for the next drink of the week</a> </p>";

            } else {
                echo "<nav class='navbar'>";
                echo "<div class='navbar-logo'>Drink of the Week</div>";
                echo "<ul class='navbar-links'>";
                echo "<li><a href='index.php'>Home</a></li>";
                echo "<li><a href='create-account.php'>Create Account</a></li>";
                echo "<li><a href='login.php'>Login</a></li>";
                echo "</ul>";
                echo "</nav>";
                // echo "<p>You are currently logged out. <a href='login.php'>Login</a></p>";
            }
        } catch (PDOException $e) {
            echo "Database error: " . htmlspecialchars($e->getMessage());
            echo "<div class='error-message'>$errorMessage</div>";



        }




        ?>


        <div class = "text-container" >
            <p> Welcome to the Drink of the Week Home Page. Here you can view the current drink of the week, and vote for the next drink of the week. </p>

            <?php
               if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true) {
                // echo "<p> You are currently logged in. </p>";                       
                echo "<h3 > <a href='voting-page.php'>Vote for the next drink of the week</a> </h3>";
               }else {
                echo "<p>You are currently logged out. You can log in at <a href='login.php'>Login</a></p>";
                echo "<p> You can also create an account at <a href='create-account.php'>Create Account</a></p>";
               }



            ?>
            <div class="drink-of-the-week-container"> 
                <h2> Current Drink of the Week </h2>
                <!-- <div class="drink-of-the-week"> -->
                <div class="card-item">
                    <?php
                    // $q = $pdo->query(
                    // "SELECT * FROM  DrinkOfTheWeek as dotw
                    // INNER JOIN Drinks  as d on dotw.drink_id = d.id
                    // ORDER BY dotw.id DESC LIMIT 1
                    // ");
                    // $row = $q->fetch();
                    // echo "<h3>" . htmlspecialchars($row["name_of_drink"]) . "</h3>";
                    // echo "<p>" . htmlspecialchars($row["descripton"]) . "</p>";
                    // echo "<p> Price : $" . htmlspecialchars($row["price"]) . "</p>";

                   try{
                    $dotw = $pdo->query(
                        "SELECT * FROM Drinks
                        ORDER by Likes DESC LIMIT 1
                        ");
                        $row = $dotw->fetch();
                        echo "<h3>" . htmlspecialchars($row["name_of_drink"]) . "</h3>";
                        echo "<p>" . htmlspecialchars($row["descripton"]) . "</p>";
                        echo "<p> Price : $" . htmlspecialchars($row["price"]) . "</p>";
                     }catch(PDOException $e){
                        echo "Database error: " . htmlspecialchars($e->getMessage());
                        echo "<div class='error-message'>No drinks selected yet</div>";
                     }

                    ?>
                </div>

            </div>
               
         <!-- <img src="assets/drinks.webp" alt="drink" style="width: 60%; height: 60%;  "> -->
       
            
        </div>

        



   
        

        <div class="footer"> 
            <p> &copy; 2024 Drink of the Week </p>
            <p> Made by Dyrel Lumiwes </p>
            

        </div>
    </div>



</body>

</html>