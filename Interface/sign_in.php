<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php'; 

function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];
    $gender = sanitizeInput($_POST['gender']);
    $telephone = sanitizeInput($_POST['telephone']);

    // Check for empty fields
    if (empty($username) || empty($email) || empty($password) || empty($gender) || empty($telephone)) {
        $_SESSION['error_message'] = "Please fill all the required fields.";
        header("Location: sign-in.php");
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Invalid email format.";
        header("Location: sign-in.php");
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=SA4U", $usernameDB, $passwordDB);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if username or email already exists
        $checkStmt = $pdo->prepare("SELECT * FROM user WHERE UserName = :UserName OR Email = :Email");
        $checkStmt->bindParam(':UserName', $username);
        $checkStmt->bindParam(':Email', $email);
        $checkStmt->execute();
        
        if ($checkStmt->rowCount() > 0) {
            $_SESSION['error_message'] = "Username or Email already exists.";
            header("Location: sign-in.php");
            exit;
        }

        // Insert new user
        $stmt = $pdo->prepare("INSERT INTO user (UserName, Email, Password, Gender, Telephone) VALUES (:UserName, :Email, :Password, :Gender, :Telephone)");
        
        $stmt->bindParam(':UserName', $username);
        $stmt->bindParam(':Email', $email);
        $stmt->bindParam(':Password', $hashed_password);
        $stmt->bindParam(':Gender', $gender);
        $stmt->bindParam(':Telephone', $telephone);

        $stmt->execute();

        header("Location: login.html");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Error: " . $e->getMessage();
        header("Location: sign-in.php");
        exit;
    }
    $pdo = null;
} else {
    header("Location: sign-in.php"); 
    exit;
}
?>
