<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SA4U - View Reviews</title>
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
    <h2>Reviews Submitted</h2>
    <div class="reviews-list">
        <?php
        require 'config.php'; 
        try {
            $conn = new PDO("mysql:host=$servername;port=3307;dbname=SA4U", $usernameDB, $passwordDB);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("SELECT rating, review FROM productreview ORDER BY ReviewID DESC");
            $stmt->execute();

            // Set the resulting array to associative
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach($stmt->fetchAll() as $review) {
                echo "<div class='review'>";
                echo "<p>Star Rating: " . str_repeat("⭐", $review['rating']) . "</p>";
                echo "<p>Review Comment: " . htmlspecialchars($review['review']) . "</p>";
                echo "</div>";
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
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
