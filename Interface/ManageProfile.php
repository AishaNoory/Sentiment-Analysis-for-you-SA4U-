<?php
session_start();

require 'config.php'; 

// Redirect to login page if not logged in
if (!isset($_SESSION['UserID'])) {
    header('Location: login.html');
    exit;
}

// Initialize variables to hold user details and messages
$user = ['UserName' => '', 'Email' => '', 'Gender' => '', 'Telephone' => ''];
$errorMsg = '';
$successMsg = '';

// Fetch user details for display in the form
try {
    $conn = new PDO("mysql:host=$servername;port=3307;dbname=SA4U", $usernameDB, $passwordDB);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT UserName, Email, Gender, Telephone FROM user WHERE UserID = ?");
    $stmt->execute([$_SESSION['UserID']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $errorMsg = "Error: " . $e->getMessage();
}

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    // Gender is not being updated, so it's not fetched from POST
    $telephone = $_POST['telephone'];

    try {
        $updateStmt = $conn->prepare("UPDATE user SET UserName = ?, Email = ?, Telephone = ? WHERE UserID = ?");
        $updateStmt->execute([$username, $email, $telephone, $_SESSION['UserID']]);

        $successMsg = "Profile updated successfully.";
        // Optionally, redirect the user to Homepage.html after successful update
        echo "<script>window.location.href = 'Homepage.html';</script>";

        // Refresh user details after update, without changing gender
        $user = ['UserName' => $username, 'Email' => $email, 'Gender' => $user['Gender'], 'Telephone' => $telephone];
    } catch (PDOException $e) {
        $errorMsg = "Error updating profile: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SA4U - Manage Profile</title>
    <link rel="stylesheet" href="Userin.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .content {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(243, 59, 59, 0.5);
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="email"], select {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; 
        }
        button[type="submit"] {
            background-color: rgba(240, 130, 148); 
            color: white;
            padding: 15px 20px;
            margin: 10px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<header>
    <div class="navbar">
        <a class="HOME" href="Homepage.html">Home</a>
        <a href="submit_review_main.php">Submit Review</a>
        <a href="viewpage.html">View Reviews</a>
        <a href="UserProfile.php">User Profile</a>
        <a href="sign-in.php">Register</a>
        <a href="login.html">Log In</a>
        <a href="adminui.php">Admin</a>
    </div>
</header>

<div class="content">
    <h2>Manage Your Profile</h2>
    <?php if (!empty($errorMsg)): ?>
        <p style="color: red;"><?php echo $errorMsg; ?></p>
    <?php endif; ?>
    <?php if (!empty($successMsg)): ?>
        <p style="color: green;"><?php echo $successMsg; ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['UserName']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" required>

        <!-- Gender Display (non-editable) -->
        <label for="gender">Gender:</label>
        <input type="text" id="gender" name="gender" value="<?php echo htmlspecialchars($user['Gender']); ?>" readonly>

        <label for="telephone">Telephone:</label>
        <input type="text" id="telephone" name="telephone" value="<?php echo htmlspecialchars($user['Telephone']); ?>" required>

        <button type="submit">Update Profile</button>
    </form>
</div>

<footer>
    <!-- Footer content as in UserProfile.php -->
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
