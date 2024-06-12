<?php
session_start(); 

// Your session-based authentication check here

header('Content-Type: application/json; charset=utf-8');

// Path to the sentiment analysis results JSON file using DIRECTORY_SEPARATOR for better cross-platform compatibility
$jsonFilePath = join(DIRECTORY_SEPARATOR, array('C:', 'xampp', 'htdocs', 'Interface', 'Sentiment_results.json'));

try {
    // Ensure the file exists
    if (!file_exists($jsonFilePath)) {
        throw new Exception("Results file not found.");
    }

    // Read and return the content of the JSON file
    $jsonData = file_get_contents($jsonFilePath);
    if ($jsonData === false) {
        // Additional error handling in case file_get_contents fails
        throw new Exception("Failed to read from the JSON file.");
    }
    echo $jsonData;

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

?>
