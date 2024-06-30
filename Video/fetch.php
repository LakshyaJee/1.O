<?php
header('Content-Type: application/json');

// Check if 'key' parameter is present in the URL
if (!isset($_GET['key'])) {
    echo json_encode(['error' => 'No key provided']);
    exit;
}

$key = $_GET['key'];
$type = $_GET['type'] ?? 'lecture';
$slug = $_GET['slug'] ?? 'null';

// Construct the URL
$apiUrl = "https://devjisu.com/drm/fetch.php?key={$key}&type={$type}&slug={$slug}";

// Initialize cURL session
$ch = curl_init();

// Set the cURL options
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Execute the cURL request
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo json_encode(['error' => curl_error($ch)]);
    curl_close($ch);
    exit;
}

// Close cURL session
curl_close($ch);

// Decode the JSON response
$responseData = json_decode($response, true);

// Check if responseData contains the keys we need
if (!isset($responseData['k']) || !isset($responseData['kid'])) {
    echo json_encode(['error' => 'Invalid response data']);
    exit;
}

// Return the DRM data as JSON
echo json_encode([
    'k' => $responseData['k'],
    'kid' => $responseData['kid']
]);
?>
