<?php
        // Start a session to track login status
        session_start();

        // Display any error message
        // if (isset($error_message)) {
        //     echo "<p class='error-message'>" . htmlspecialchars($error_message) . "</p>";
        // }

        // Database connection parameters
        $db_host = '192.168.2.12';
        $db_name = 'drinksDB';
        $db_user = 'webuser';
        $db_passwd = 'password';

        $pdo_dsn = "mysql:host=$db_host;dbname=$db_name";

            // Connect to the database
            $pdo = new PDO($pdo_dsn, $db_user, $db_passwd);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if the form has been submitted
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Retrieve username and password from form
                $username = trim($_POST['username']);
                $password = trim($_POST['password']);

                // Prepare a SQL statement to prevent SQL injection
                // $stmt = $pdo->prepare("SELECT * FROM Users WHERE username = :username LIMIT 1");
                // $stmt->bindParam(':username', $username);
                // $stmt->execute();
                // $user = $stmt->fetch(PDO::FETCH_ASSOC);
                $stmt = $pdo->prepare("SELECT * FROM Users WHERE username = :username and user_password = :password");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':password', $password);
                $stmt->execute();
                $existing_user = $stmt->fetch(PDO::FETCH_ASSOC);

                // Verify the password
                if ($existing_user ){ #&& password_verify($password, $existing_user['password'])) {
                    // Set session variable to track login status
                    $_SESSION['logged_in'] = true;
                    $_SESSION['username'] = $username;

                    // Redirect to the home page or dashboard
                    header('Location: index.php');
                    exit;

                } else {
                    // Display an error message if login failed
                    $error_message = 'Invalid username or password';
                    echo "<p class='error-message'> Invalid username or password </p>";
                }
            }else{
                echo "<p> Please enter your username and password to login. </p>";
            }
      


        ?>
<!DOCTYPE html>
<html>
<head>
<style>
<?php include 'css/style.css'; ?>
@font-face {
    font-family: "montserrat";
    src: url(Montserrat-Regular.woff2);
    
        }
    body{
        font-family: 'montserrat', sans-serif;
    }
</style>
    <title>Login Page</title>
    <!-- <link rel="stylesheet" href="/css/style.css"> -->

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
        
    </div>


</body>
</html>
