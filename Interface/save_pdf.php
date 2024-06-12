<!-- <?php
// Check if the request contains PDF data
if (isset($_POST['pdfData'])) {
    // Decode the Base64 string back to binary
    $pdfData = base64_decode($_POST['pdfData']);
    
    // Define where to save the PDF and under what file name
    $filePath = 'C:/xampp/htdocs/Interface/reports/dashboard_report_' . time() . '.pdf';
    
    // Save the PDF to the server
    file_put_contents($filePath, $pdfData);
    
    // Respond to the request
    echo json_encode(['message' => 'PDF report saved successfully.']);
} else {
    // Handle cases where PDF data isn't set
    http_response_code(400);
    echo json_encode(['message' => 'No PDF data received.']);
}
?> -->
