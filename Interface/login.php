<?php
session_start();
header('Content-Type: application/json');

ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'config.php'; 

$response = ['success' => false, 'message' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim(htmlspecialchars($_POST['username']));
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $response['message'] = "Please enter username and password.";
    } else {
        try {
            $conn = new PDO("mysql:host=$servername;port=3307;dbname=$dbname", $usernameDB, $passwordDB);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("SELECT UserID, UserName, Password FROM user WHERE UserName = :UserName");
            $stmt->bindParam(':UserName', $username, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($password, $row['Password'])) {
                session_regenerate_id();
                $_SESSION['loggedin'] = true;
                $_SESSION['UserID'] = $row['UserID'];
                $_SESSION['UserName'] = $row['UserName'];
                $response['success'] = true;
                $response['message'] = "Login successful.";
            } else {

                    $response['message'] = "The password you entered was not valid.";
                }
            } else {
                $response['message'] = "No account found with that username.";
            }
        } catch (PDOException $e) {
            $response['message'] = "Error: " . $e->getMessage();
        }
        
        $conn = null;
    }
    echo json_encode($response);
    exit;
}
?>
