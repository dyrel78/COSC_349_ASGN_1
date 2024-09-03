
<?php

session_start(); 
?>

<?php
     

        // Database connection parameters
$db_host = '192.168.2.12';
$db_name = 'drinksDB';
$db_user = 'webuser';
$db_passwd = 'password';

$pdo_dsn = "mysql:host=$db_host;dbname=$db_name";

// try {
    // Connect to the database
    $pdo = new PDO($pdo_dsn, $db_user, $db_passwd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve username and password from form
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $email = trim($_POST['email']);
        $age = trim($_POST['age']);
        $gender = trim($_POST['gender']);

        // Check if username already exists
        if (empty($username) || empty($password) || empty($email) || empty($age) || empty($gender)) {
            $message = 'All fields are required.';
            $error = true;
        } elseif (strlen($username) < 3 || strlen($password) < 5) {
            $message = 'Username must be at least 3 characters and password at least 5 characters.';
            $error = true;
        }else{
            $stmt = $pdo->prepare("SELECT * FROM Users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $existing_user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existing_user) {
                // If username is taken, show an error message
                $message = 'Username already exists. Please choose a different one.';
                $error = true;
            } else {
                // Hash the password before storing
                // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert new user into the database
                $stmt = $pdo->prepare("INSERT INTO Users (username, user_password, email, age, gender) VALUES (:username, :password, :email, :age, :gender)");
                $stmt->bindParam(':username', $username);
                // $stmt->bindParam(':password', $hashed_password);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':age', $age, PDO::PARAM_INT);
                $stmt->bindParam(':gender', $gender);

                if ($stmt->execute()) {
                    // Display success message
                    $message = 'Account created successfully! You can now login.';
                    // $message = 'Account created successfully! You can now <a href="login.php">login</a>.';

                } else {
                    // Display error message
                    $message = 'An error occurred while creating your account. Please try again.';
                    $error = true;
                }
        }
      


    }
        
    }
// } catch (PDOException $e) {
//     $message = "Database error: " . htmlspecialchars($e->getMessage());
//     $error = true;
// }
        ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Create Account</title>
    <style>
<?php include 'css/style.css'; ?>
<?php include 'css/navbar.css'; ?>
</style>
</head>
<body>


<!-- create table Users (
    id int primary key auto_increment,
    admin_flag boolean default false,
    username varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    user_password varchar(255) NOT NULL,
    liked_drink_id int,
    age int,
    gender varchar(255),
    foreign key (liked_drink_id) references Drinks(id)
); -->
    <div class="container">
        <nav class="navbar">
            <div class="navbar-logo">Drinks App</div>
            <ul class="navbar-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>

        <div class="text-container">
        <h2>Create Account</h2>
        <form action="create-account.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for = "email">Email:</label>
            <input type = "text" id = "email" name = "email" required>

            <label for = "age">Age:</label>
            <input type = "text" id = "age" name = "age" required>

            <label for = "gender"> Gender:</label>
            <select name="gender" id="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
                <option value="prefer_not_to_say">Prefer Not To Say</option>

            </select>
            
            <input type="submit" value="Create Account">
        </form>
        <?php
        // Display any message (error or success)
        if (isset($message)) {
            echo "<p class='" . (isset($error) ? 'error-message' : 'success-message') . "'>" . htmlspecialchars($message) . "</p>";
        }
        ?>
        </div>

       
    </div>
        <div class="footer"> 
            <p> &copy; 2024 Drink of the Week </p>
            <p> Made by Dyrel Lumiwes </p>
        </div>
   
</body>
</html>
