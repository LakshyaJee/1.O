<?php
header('Content-Type: application/json');

// Check if required parameters are present in the URL
if (!isset($_GET['key']) || !isset($_GET['type']) || !isset($_GET['slug'])) {
    echo json_encode(['error' => 'Missing required parameters']);
    exit;
}

$key = $_GET['key'];
$type = $_GET['type'];
$slug = $_GET['slug'];

// Construct the URL for the external request
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
if (!isset($responseData['k']) || !isset($responseData['kid']) || !isset($responseData['video_url']) || !isset($responseData['image_url']) || !isset($responseData['telegram_link'])) {
    echo json_encode(['error' => 'Invalid response data']);
    exit;
}

// Return the DRM data as JSON
echo json_encode([
    'keys' => [
        [
            'k' => $responseData['k'],
            'kid' => $responseData['kid'],
            'video_url' => $responseData['video_url'],
            'image_url' => $responseData['image_url'],
            'telegram_link' => $responseData['telegram_link']
        ]
    ]
]);
?>
