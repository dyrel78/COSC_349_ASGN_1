<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>

<head>
    <title>Database Test Page</title>
    <style>
        <?php include 'css/style.css'; ?><?php include 'css/navbar.css'; ?><?php include 'css/data-display-page.css'; ?>@font-face {
            font-family: "montserrat";
            src: url(css/Montserrat-Regular.woff2);
        }

        body {
            font-family: 'montserrat', sans-serif;
        }

        th {
            text-align: left;
        }

        table,
        th,
        td {
            border: 2px solid grey;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 0.2em;
        }

        h2 {
            padding-top: 20px;
        }

        .grid-container {
            display: grid;
            grid-template-columns: auto auto;
            padding: 10px;
        }




        /* Navbar container */
        .navbar {
            background-color: #0073e6;
            overflow: hidden;
        }

        /* Navbar links */
        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 17px;
        }

        /* Change color on hover */
        .navbar a:hover {
            background-color: #005bb5;
            color: white;
        }

        /* Responsive Navbar */
        @media screen and (max-width: 600px) {
            .navbar a {
                float: none;
                display: block;
                text-align: left;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <nav class="navbar">
            <div class="navbar-logo">Drinks App</div>
            <ul class="navbar-links">
                <li><a href="index.php">Home</a></li>
                <!-- <li><a href="/add">Add Drink</a></li> -->
                <li><a href="logout.php">Logout</a></li>
                <!-- <li><a href="about.php">About</a></li> -->
            </ul>
        </nav>
        <h1>Database Test Page </h1>

        <h2>Showing contents of Drinks table:</h2>
        <div class="grid-container">
            <table border="1">
                <tr>
                    <th>Name of Drink</th>
                    <th>Likes TESTING</th>
                </tr>

                <?php
                $db_host   = '192.168.2.12';
                $db_name   = 'drinksDB';
                $db_user   = 'webuser';
                $db_passwd = 'password';

                $pdo_dsn = "mysql:host=$db_host;dbname=$db_name";

                try {
                    $pdo = new PDO($pdo_dsn, $db_user, $db_passwd);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Query to fetch top-rated drinks
                    $sql = "SELECT name_of_drink, likes FROM Drinks ORDER BY likes DESC";
                    $stmt = $pdo->query($sql);

                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["name_of_drink"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["likes"]) . "</td>";
                            echo "</tr>\n";
                        }
                    } else {
                        echo "<tr><td colspan='2'>No drinks found.</td></tr>";
                    }

                    // Suggest drinks with rating below a certain threshold
                    echo "</table>";

                    $threshold = 4.0; // Adjust the threshold as needed
                    $sql = "SELECT name_of_drink, rating FROM Drinks WHERE rating < :threshold";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([':threshold' => $threshold]);

                    if ($stmt->rowCount() > 0) {
                        echo "<h2>Drinks to Consider Removing or Improving:</h2>";
                        echo "<h3>Drinks with a rating below $threshold:</h3>";
                        echo "<table border='1'><tr><th>Name of Drink</th><th>Rating</th></tr>";
                        while ($row = $stmt->fetch()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["name_of_drink"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["rating"]) . "</td>";
                            echo "</tr>\n";
                        }
                        echo "</table>";
                    } else {
                        echo "<h2>All drinks have a rating above the threshold.</h2>";
                    }

                    // Query to fetch drinks liked by male users, ordered by the number of likes
                    $sql = "SELECT d.name_of_drink, COUNT(ul.user_id) AS male_likes_count
            FROM Drinks d
            JOIN UserLikes ul ON d.id = ul.drink_id
            JOin Users u ON ul.user_id = u.id
            WHERE u.gender = 'male'
            GROUP BY d.name_of_drink
            ORDER BY male_likes_count DESC";

                    $stmt = $pdo->query($sql);

                    if ($stmt->rowCount() > 0) {
                        echo "<h2>Top Drinks Liked by Male Users:</h2>";
                        echo "<table border='1'><tr><th>Name of Drink</th><th>Male Likes Count</th></tr>";
                        while ($row = $stmt->fetch()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["name_of_drink"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["male_likes_count"]) . "</td>";
                            echo "</tr>\n";
                        }
                        echo "</table>";
                    } else {
                        echo "<h2>No drinks liked by male users found.</h2>";
                    }


                    $sql = "SELECT d.name_of_drink, COUNT(ul.user_id) AS female_likes_count
            FROM Drinks d
            JOIN UserLikes ul ON d.id = ul.drink_id
            JOin Users u ON ul.user_id = u.id
            WHERE u.gender = 'female'
            GROUP BY d.name_of_drink
            ORDER BY female_likes_count DESC";

                    $stmt = $pdo->query($sql);

                    if ($stmt->rowCount() > 0) {
                        echo "<h2>Top Drinks Liked by Female Users:</h2>";
                        echo "<table border='1'><tr><th>Name of Drink</th><th>Female Likes Count</th></tr>";
                        while ($row = $stmt->fetch()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["name_of_drink"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["female_likes_count"]) . "</td>";
                            echo "</tr>\n";
                        }
                        echo "</table>";
                    } else {
                        echo "<h2>No drinks liked by female users found.</h2>";
                    }




                    $sql = "SELECT d.name_of_drink, COUNT(ul.user_id) AS other_likes_count
            FROM Drinks d
            JOIN UserLikes ul ON d.id = ul.drink_id
            JOin Users u ON ul.user_id = u.id
            WHERE u.gender = 'other'
            GROUP BY d.name_of_drink
            ORDER BY other_likes_count DESC";

                    $stmt = $pdo->query($sql);

                    if ($stmt->rowCount() > 0) {
                        echo "<h2>Top Drinks Liked by Other Users:</h2>";
                        echo "<table border='1'><tr><th>Name of Drink</th><th>Other Likes Count</th></tr>";
                        while ($row = $stmt->fetch()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["name_of_drink"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["other_likes_count"]) . "</td>";
                            echo "</tr>\n";
                        }
                        echo "</table>";
                    } else {
                        echo "<h2>No drinks liked by other users found.</h2>";
                    }

                    $sql = "SELECT d.name_of_drink, COUNT(ul.user_id) AS 18_24_likes_count
                FROM Drinks d
                JOIN UserLikes ul ON d.id = ul.drink_id
                JOin Users u ON ul.user_id = u.id
                WHERE u.age BETWEEN 18 AND 24
                GROUP BY d.name_of_drink
                ORDER BY 18_24_likes_count DESC";

                    $stmt = $pdo->query($sql);

                    if ($stmt->rowCount() > 0) {
                        echo "<h2>Top Drinks Liked by Users Aged between 18 and 24:</h2>";
                        echo "<table border='1'><tr><th>Name of Drink</th><th>Likes Count</th></tr>";
                        while ($row = $stmt->fetch()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["name_of_drink"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["18_24_likes_count"]) . "</td>";
                            echo "</tr>\n";
                        }
                        echo "</table>";
                    } else {
                        echo "<h2>No drinks liked by 18-24 year olds found.</h2>";
                    }


                    $sql = "SELECT d.name_of_drink, COUNT(ul.user_id) AS 25_34_likes_count
                FROM Drinks d
                JOIN UserLikes ul ON d.id = ul.drink_id
                JOin Users u ON ul.user_id = u.id
                WHERE u.age BETWEEN 25 AND 34
                GROUP BY d.name_of_drink
                ORDER BY 25_34_likes_count DESC";

                    $stmt = $pdo->query($sql);

                    if ($stmt->rowCount() > 0) {
                        echo "<h2>Top Drinks Liked by Users Aged between 25 and 34:</h2>";
                        echo "<table border='1'><tr><th>Name of Drink</th><th>Likes Count</th></tr>";
                        while ($row = $stmt->fetch()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["name_of_drink"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["25_34_likes_count"]) . "</td>";
                            echo "</tr>\n";
                        }
                        echo "</table>";
                    } else {
                        echo "<h2>No drinks liked by 25-34 year olds found.</h2>";
                    }


                    $sql = "SELECT d.name_of_drink, COUNT(ul.user_id) AS 35_44_likes_count
                FROM Drinks d
                JOIN UserLikes ul ON d.id = ul.drink_id
                JOin Users u ON ul.user_id = u.id
                WHERE u.age BETWEEN 35 AND 44
                GROUP BY d.name_of_drink
                ORDER BY 35_44_likes_count DESC";

                    $stmt = $pdo->query($sql);

                    if ($stmt->rowCount() > 0) {
                        echo "<h2>Top Drinks Liked by Users Aged between 35 and 44:</h2>";
                        echo "<table border='1'><tr><th>Name of Drink</th><th>Likes Count</th></tr>";
                        while ($row = $stmt->fetch()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["name_of_drink"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["35_44_likes_count"]) . "</td>";
                            echo "</tr>\n";
                        }
                        echo "</table>";
                    } else {
                        echo "<h2>No drinks liked by 35-44 year olds found.</h2>";
                    }

                    $sql = "SELECT d.name_of_drink, COUNT(ul.user_id) AS 45_54_likes_count
                    FROM Drinks d
                    JOIN UserLikes ul ON d.id = ul.drink_id
                    JOin Users u ON ul.user_id = u.id
                    WHERE u.age BETWEEN 45 AND 54
                    GROUP BY d.name_of_drink
                    ORDER BY 45_54_likes_count DESC";

                    $stmt = $pdo->query($sql);

                    if ($stmt->rowCount() > 0) {
                        echo "<h2>Top Drinks Liked by Users Aged between 45 and 54:</h2>";
                        echo "<table border='1'><tr><th>Name of Drink</th><th>Likes Count</th></tr>";
                        while ($row = $stmt->fetch()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["name_of_drink"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["45_54_likes_count"]) . "</td>";
                            echo "</tr>\n";
                        }
                        echo "</table>";
                    } else {
                        echo "<h2>No drinks liked by 45-54 year olds found.</h2>";
                    }
                } catch (PDOException $e) {
                    echo "<p>Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
                }








                ?>
        </div>
        <div>

            <p> Link to upload <a href="upload-page.php"> Click Me </a></p>
        </div>

        <div class="footer">
            <p> &copy; 2024 Drink of the Week </p>
            <p> Made by Dyrel Lumiwes </p>


        </div>
        <!-- container -->
    </div>
</body>

</html>