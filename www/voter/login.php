<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <input type="submit" value="Login">
        </form>
        <?php
        // Display any error message
        if (isset($error_message)) {
            echo "<p class='error-message'>" . htmlspecialchars($error_message) . "</p>";
        }
// Start a session to track login status
        session_start();

        // Database connection parameters
        $db_host = '192.168.2.12';
        $db_name = 'drinksDB';
        $db_user = 'webuser';
        $db_passwd = 'password';

        $pdo_dsn = "mysql:host=$db_host;dbname=$db_name";

        try {
            // Connect to the database
            $pdo = new PDO($pdo_dsn, $db_user, $db_passwd);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if the form has been submitted
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Retrieve username and password from form
                $username = $_POST['username'];
                $password = $_POST['password'];

                // Prepare a SQL statement to prevent SQL injection
                $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
                $stmt->bindParam(':username', $username);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                // Verify the password
                if ($user && password_verify($password, $user['password'])) {
                    // Set session variable to track login status
                    $_SESSION['logged_in'] = true;
                    $_SESSION['username'] = $username;

                    // Redirect to the home page or dashboard
                    header('Location: voting-page.php');
                    exit;
                } else {
                    // Display an error message if login failed
                    $error_message = 'Invalid username or password';
                }
            }
        } catch (PDOException $e) {
            echo "Database error: " . htmlspecialchars($e->getMessage());
        }


        ?>
    </div>


</body>
</html>
