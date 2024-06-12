<?php
require 'config.php'; // Include the database connection parameters

// Create the PDO connection using parameters from config.php
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $usernameDB, $passwordDB);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ensure the table name 'user' and column names 'Username', 'Email' match your database schema
    $stmt = $pdo->prepare("SELECT Username, Email FROM user");
    $stmt->execute();

    // Fetch all users
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users</title>
    <link rel="stylesheet" href="Userin.css">
    <style>
    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        padding: 20px;
        background-color:#f7a6a6; /* Matching the modal content background color */
        margin: 20px auto; /* Centering the container */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Adding some shadow for depth */
        width: 80%; /* Matching the modal content width */
        border: 1px solid #f77474; /* Matching the modal content border */
    }

    .user-table {
        width: 100%; /* Table width to fill the container */
        border-collapse: collapse;
        margin-top: 20px; /* Space between the table and the rest of the container content */
    }

    .user-table th, .user-table td {
        border: 1px solid #ddd; /* Lighter border color for the table */
        padding: 12px 15px; /* Padding for table cells */
        text-align: left;
        background-color: #fff; /* Background color for table cells */
        color: black; /* Setting text color to black */
    }

    .user-table th {
        background-color: #f9f9f9; /* Different background for table headers */
    }

    .user-table tr:nth-child(odd) {
        background-color: #f2f2f2; /* Zebra striping for rows */
    }

    .user-table tr:hover {
        background-color: #e2e2e2; /* Hover state for rows */
    }
</style>



</head>
<body>
    <div class="container">
        <h2>User List</h2>
        <table class="user-table">
            <tr>
                <th>Username</th>
                <th>Email</th>
            </tr>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['Username']); ?></td>
                <td><?= htmlspecialchars($user['Email']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
