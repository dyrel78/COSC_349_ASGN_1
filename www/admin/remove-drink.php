<?php
session_start(); // Start the session
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Database credentials
$db_host = '192.168.2.12';
$db_name = 'drinksDB';
$db_user = 'admin_account';
$db_passwd = 'strong_admin_password';

// DSN for PDO connection
$pdo_dsn = "mysql:host=$db_host;dbname=$db_name";

try {
    // Connect to the database
    $pdo = new PDO($pdo_dsn, $db_user, $db_passwd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form has been submitted via POST
    if (isset($_POST['id']) || $_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the drink id from the form input
        $id = trim($_POST['id']);

        // Delete associated entries in the UserLikes table
        $userLikes = $pdo->prepare("DELETE FROM UserLikes WHERE drink_id = :id");
        $userLikes->bindParam(':id', $id, PDO::PARAM_INT);
        $userLikes->execute();

        $id = trim($_POST['id']);


        //update users liked drink to null
        $likedDrinkId = $pdo->prepare("UPDATE Users SET liked_drink_id = NULL WHERE liked_drink_id = :id");
        $likedDrinkId->bindParam(":id", $id, PDO::PARAM_INT);
        $likedDrinkId->execute();
        // $likedDrink = $likedDrinkId->fetch(PDO::FETCH_ASSOC);
        

        // Delete the drink from the Drinks table
        $deleteDrink = $pdo->prepare('DELETE FROM Drinks WHERE id = :id');
        $deleteDrink->bindParam(':id', $id, PDO::PARAM_INT);
        // $deleteDrink->execute();

        if( $deleteDrink->execute() ){
            // Feedback for the user 
            echo "<p> Drink and associated likes deleted successfully. </p>";
 

            $success_message = 'Drink deleted successfully.';
        }else{
            echo "Error deleting drink.";
            echo "<p> Drink not deleted. </p>";
        }

    }

} catch (PDOException $e) {
    // Handle any errors during the database operations
    echo "Error: " . $e->getMessage();

}

header("Location: admin-page.php");
exit;
?>
