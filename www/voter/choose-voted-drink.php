

<!-- This page is for when a user has chosen their vote -->
<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

// Database connection parameters
$db_host = '192.168.2.12';
$db_name = 'drinksDB';
$db_user = 'webuser';
$db_passwd = 'password';

$pdo_dsn = "mysql:host=$db_host;dbname=$db_name";

try {
    $pdo = new PDO($pdo_dsn, $db_user, $db_passwd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form has been submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $drinkId = trim($_POST['drink_id']);
        $userId = trim($_SESSION['user_id']);

    
        // Delete User's old vote
        $deleteOldDrinkQuery = "DELETE FROM UserLikes WHERE user_id = ?";
        $deleteOldDrinkQueryStmt = $pdo ->prepare($deleteOldDrinkQuery);
        $deleteOldDrinkQueryStmt->execute([$userId]);
        $deleteOldDrinkQueryStmt->closeCursor();

        //Decrementing Drink votes is done in sql database

        // update the user's liked drink
        $updateLikedDrinkQuery = "UPDATE Users SET liked_drink_id = ? WHERE id = ?";
        $updateLikedDrinkStmt = $pdo->prepare($updateLikedDrinkQuery);
        $updateLikedDrinkStmt->execute([$drinkId, $userId]);
        $updateLikedDrinkStmt->closeCursor();
        

         //insert into the userlikes table
        $insertLikeQuery = "INSERT INTO UserLikes (user_id, drink_id) VALUES (?, ?)";
        $insertLikeStmt = $pdo->prepare($insertLikeQuery);
        $insertLikeStmt->execute([$userId, $drinkId]);
        $insertLikeStmt->closeCursor();

        // Redirect the user back to the login page or home page 
        // to make it seem "dynamic"
        header("Location: voting-page.php");
        exit;
    }

    }catch (PDOException $e) {
        echo "Database error: " . htmlspecialchars($e->getMessage());
    }
?>
