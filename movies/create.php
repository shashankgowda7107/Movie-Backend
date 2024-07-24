<?php
error_reporting(0);

// Allow from any origin
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, x-Requested-With');
header('Content-Type: application/json');

include('function.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

// Handle OPTIONS request
if ($requestMethod === 'OPTIONS') {
    // Respond to preflight request
    header('HTTP/1.1 204 No Content');
    exit();
} elseif ($requestMethod === 'POST') {
    $inputData = json_decode(file_get_contents('php://input'), true);
    if (empty($inputData)) {
        $storeMovie = storeMovie($_POST);
    } else {
        $storeMovie = storeMovie($inputData);
    }
    echo $storeMovie;
} else {
    // Handle other HTTP methods
    $data = [
        'status' => 405,
        'message' => $requestMethod . ' Method Not Allowed',
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}
?>