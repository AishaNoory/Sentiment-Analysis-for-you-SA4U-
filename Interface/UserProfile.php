<?php
session_start();

// Check if the user is logged in, using the session variable used during login
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    require 'config.php'; // Ensure this points to your actual config file
    
    try {
        $conn = new PDO("mysql:host=$servername;port=3307;dbname=SA4U", $usernameDB, $passwordDB);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Use the correct session variable name, adjust as per your login logic
        $stmt = $conn->prepare("SELECT UserName, Email, Gender, Telephone FROM user WHERE UserID = ?");
        $stmt->execute([$_SESSION['UserID']]);
        $userProfile = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Connection error: " . $e->getMessage();
    }
} else {
    // Redirect to login page if not logged in
    header("Location: Login.html");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SA4U - User Profile</title>
    <link rel="stylesheet" href="Userin.css">
</head>
<body>

<header>
    <div class="navbar">
        <a class="HOME" href="Homepage.html">Home</a>
        <a href="submit_review_main.php">Submit Review</a>
        <a href="viewpage.php">View Reviews</a>
        <a href="UserProfile.php">User Profile</a>
        <a href="sign-in.php">Register</a>
        <a href="login.html">Log In</a>
        <a href="adminui.php">Admin</a>
    </div>
    <div>
            <h1>SA4U</h1>
            <p style="font-size: 20px; margin-top: -10px;"><b>Sentiment Analysis for You</b></p>
        </div>
</header>

<div class="content">
    <div class="form">
        <h2>User Profile</h2>
        <?php if ($userProfile): ?>
            <p><b>Welcome to your user profile page.</b><br>Here, you can view your profile information.</p>
            <div class="profile-details">
                <p><strong>Username:</strong> <?php echo htmlspecialchars($userProfile['UserName']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($userProfile['Email']); ?></p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($userProfile['Gender']); ?></p>
                <p><strong>Telephone:</strong> <?php echo htmlspecialchars($userProfile['Telephone']); ?></p>
            </div>
            <button class="manage-profile-btn" onclick="window.location='Homepage.html';">Return to HomePage</button>
            <button class="manage-profile-btn" onclick="window.location='ManageProfile.php';">Manage My Profile</button>

        <?php else: ?>
            <p>An error occurred. Please try logging in again.</p>
        <?php endif; ?>
    </div>
</div>

<footer>
    <div class="footer-content">
        <div class="social-media">
            <p>Connect with us:</p>
            <a href="#" target="_blank">Facebook</a>
            <a href="#" target="_blank">Twitter</a>
            <a href="#" target="_blank">Instagram</a>
        </div>
        <div class="contact-info">
            <p>Contact us:</p>
            <p>Email: info@sa4u.com</p>
            <p>Phone: +1 123-456-7890</p>
        </div>
    </div>
</footer>

</body>
</html>
