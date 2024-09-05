<?php
session_start();
// if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
//     header('Location: login.php');
//     exit;
// }
?>

<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>

<head>
    <title>Drink of the Week Voting Page</title>
    <style>
        <?php include 'css/vote-page.css'; ?>
        <?php include 'css/navbar.css'; ?>
        

        @font-face {
            font-family: "montserrat";
            src: url(css/Montserrat-Regular.woff2);

        }


        body {
            font-family: 'montserrat', sans-serif;
        }

        .card-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 1rem;
            flex-direction: row;
            padding: 1rem;
            /* border: solid 3px red; */
        }

            /* Navbar.css */

        .footer {
            /* position: fixed; */
            position:sticky;
            width: 100%;
            /* height: 2.5%; */

        }
        .footer >p {
            color: #fff;
            font-size: 1rem;
            font-weight: bold;
            margin-right: 35px;

            }

        #selected-drink {
            background-color: lightgreen;
        }
            


    </style>


</head>

<body class=vote-body>
    <div class="card-container">

        <nav class="navbar">
            <div class="navbar-logo">Drink of the Week</div>
            <ul class="navbar-links">
                <li><a href="admin-page.php">Home</a></li>
                <!-- <li><a href="/add">Add Drink</a></li> -->
                <li><a href="upload-page.php">Upload a Drink</a></li>
                <!-- <li><a href="about.php">About</a></li> -->
            </ul>
        </nav>


        <div class="card-grid">
            <?php
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            $db_host   = '192.168.2.12';
            $db_name   = 'drinksDB';
            $db_user   = 'admin_account';
            $db_passwd = 'strong_admin_password';

            $pdo_dsn = "mysql:host=$db_host;dbname=$db_name";

            $pdo = new PDO($pdo_dsn, $db_user, $db_passwd);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $q = $pdo->query("SELECT * FROM Drinks");
        
            while ($row = $q->fetch()){
                    echo "<div class='card-item'>";
                    echo "<h3>" . htmlspecialchars($row["name_of_drink"]) . "</h3>";
                    echo "<p>" . htmlspecialchars($row["descripton"]) . "</p>";
                    echo "<p>Price: $" . htmlspecialchars($row["price"]) . "</p>";
                    // echo "<p>Rating: " . htmlspecialchars($row["rating"]) . "</p>";
                    echo "<p>Likes: " . htmlspecialchars($row["likes"]) . "</p>";
                    // echo "<button>Vote</button>";
                    // echo "<select name='rating'>" . htmlspecialchars($row["rating"])
                    echo "</div>";

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