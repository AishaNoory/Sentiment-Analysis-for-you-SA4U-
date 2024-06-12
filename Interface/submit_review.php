<?php
session_start(); 

// Include your database configuration file
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize user input
    $review = htmlspecialchars($_POST['review']);
    $rating = intval($_POST['rating']); 

    // Check if UserID exists in the session
    if(isset($_SESSION['UserID'])) {
        $userID = $_SESSION['UserID']; 

        // Create connection using PDO
        try {
            $conn = new PDO("mysql:host=$servername;port=3307;dbname=SA4U", $usernameDB, $passwordDB);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare SQL statement with UserID
            $stmt = $conn->prepare("INSERT INTO productreview (UserID, review, rating) VALUES (:userID, :review, :rating)");
            $stmt->bindParam(':userID', $userID);
            $stmt->bindParam(':review', $review);
            $stmt->bindParam(':rating', $rating);

            // Execute the prepared statement
            $stmt->execute();

            $_SESSION['message'] = "Review submitted successfully.";
        } catch(PDOException $e) {
            $_SESSION['message'] = "Error: " . $e->getMessage();
        }

        // Close connection
        $conn = null;
    } else {
        $_SESSION['message'] = "You must be logged in to submit a review.";
    }

    // Redirect back to the form page
    header('Location: viewpage.php');
    exit();
}
?>
