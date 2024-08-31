<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>
<head>
    <title>Database Test Page</title>
    <style>
        th { text-align: left; }

        table, th, td {
            border: 2px solid grey;
            border-collapse: collapse;
        }

        th, td {
            padding: 0.2em;
        }
    </style>
</head>

<body>
    <h1>Database Test Page</h1>

    <p>Showing contents of Drinks table:</p>

    <table border="1">
        <tr>
            <th>Name of Drink</th>
            <th>Likes</th>
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
                echo "<table border='1'><tr><th>Name of Drink</th><th>Rating</th></tr>";
                while ($row = $stmt->fetch()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["name_of_drink"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["rating"]) . "</td>";
                    echo "</tr>\n";
                }
                echo "</table>";
            } else {
                echo "<p>All drinks have a rating above the threshold.</p>";
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
            echo "<p>No drinks liked by male users found.</p>";
            }


            

        } catch (PDOException $e) {
            echo "<p>Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
</body>
</html>
