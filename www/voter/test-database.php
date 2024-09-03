



<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML//EN">
<html>
<head>
    <title>Database test page</title>
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
    <h1>Database test page testing </h1>

    <p>Showing contents of Drinks table:</p>

    <table border="1">
        <tr>
            <th>Drink ID</th>
            <th>Name of Drink</th>
            <th>Description</th>
            <th>Price</th>
            <th>Rating</th>
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

            $q = $pdo->query("SELECT * FROM Drinks");

            while ($row = $q->fetch()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["name_of_drink"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["descripton"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["price"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["rating"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["likes"]) . "</td>";

                echo "</tr>\n";
            }

        } catch (PDOException $e) {
            echo "Database error: " . htmlspecialchars($e->getMessage());
        }
        ?>



    </table>


    <table border ="1">
        <!-- Do a table for users -->
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Password</th>
            <th>Admin Flag</th>
            <th>Email</th>
            <th>Liked Drink ID</th>
            <th>Age</th>
            <th>Gender</th>
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

            $q = $pdo->query("SELECT * FROM Users");

            while ($row = $q->fetch()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["user_password"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["admin_flag"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["liked_drink_id"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["age"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["gender"]) . "</td>";
         

                echo "</tr>\n";
            }

        } catch (PDOException $e) {
            echo "Database error: " . htmlspecialchars($e->getMessage());
        }
        ?>



    </table>
</body>
</html>
